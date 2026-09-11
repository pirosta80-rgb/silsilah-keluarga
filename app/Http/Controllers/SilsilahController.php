<?php

namespace App\Http\Controllers;

use App\Models\Individual;
use App\Models\Marriage;
use App\Models\Relationship;
use Illuminate\Http\Request;

class SilsilahController extends Controller
{
    /**
     * Display the silsilah list with indentation (Nuclear Family only).
     */
    public function index()
    {
        $allIndividuals = Individual::orderBy('first_name')->get();

        // Get selected ID from request, default to first individual
        $selectedId = request()->input('id');

        if ($selectedId) {
            $selected = Individual::find($selectedId);
        } else {
            $selected = $allIndividuals->first();
        }

        if (!$selected) {
            return view('silsilah.index', compact('allIndividuals', 'trees'));
        }

        // Build nuclear family for selected individual
        $tree = $this->buildNuclearFamily($selected);
        $trees = $tree ? [$tree] : [];

        return view('silsilah.index', compact('trees', 'allIndividuals'));
    }

    /**
     * Build nuclear family (spouse and children only)
     */
    private function buildNuclearFamily($individual)
    {
        if (!$individual) {
            return null;
        }

        // Get spouse
        $spouse = null;
        $marriage = Marriage::where('husband_id', $individual->id)
            ->orWhere('wife_id', $individual->id)
            ->where('status', 'married')
            ->first();

        if ($marriage) {
            if ($marriage->husband_id == $individual->id) {
                $spouse = Individual::find($marriage->wife_id);
            } else {
                $spouse = Individual::find($marriage->husband_id);
            }
        }

        // Get children
        $children = Relationship::where('father_id', $individual->id)
            ->orWhere('mother_id', $individual->id)
            ->get();

        $childNodes = [];
        foreach ($children as $child) {
            $childInd = Individual::find($child->child_id);
            if ($childInd) {
                $childNodes[] = [
                    'id' => $childInd->id,
                    'name' => $childInd->full_name,
                    'gender' => $childInd->gender,
                    'birth_date' => $childInd->birth_date,
                    'death_date' => $childInd->death_date,
                    'children' => []
                ];
            }
        }

        // Sort children by birth date
        usort($childNodes, function ($a, $b) {
            return strtotime($a['birth_date'] ?? '1970-01-01') - strtotime($b['birth_date'] ?? '1970-01-01');
        });

        return [
            'id' => $individual->id,
            'name' => $individual->full_name,
            'gender' => $individual->gender,
            'birth_date' => $individual->birth_date,
            'death_date' => $individual->death_date,
            'spouse' => $spouse ? [
                'id' => $spouse->id,
                'name' => $spouse->full_name,
                'gender' => $spouse->gender,
                'birth_date' => $spouse->birth_date,
                'death_date' => $spouse->death_date,
            ] : null,
            'children' => $childNodes
        ];
    }

    /**
     * Show the relationship finder page
     */
    public function cariHubungan()
    {
        $individuals = Individual::orderBy('first_name')->get();
        return view('silsilah.cari-hubungan', compact('individuals'));
    }

    /**
     * Find relationship between two individuals
     */
    public function findRelationship(Request $request)
    {
        $request->validate([
            'person1_id' => 'required|exists:individuals,id',
            'person2_id' => 'required|exists:individuals,id|different:person1_id',
        ]);

        $person1 = Individual::find($request->person1_id);
        $person2 = Individual::find($request->person2_id);

        $graph = $this->buildGraph();
        $path = $this->bfs($graph, $person1->id, $person2->id);

        if (!$path) {
            return response()->json([
                'found' => false,
                'message' => "Tidak ditemukan hubungan antara {$person1->full_name} dan {$person2->full_name}"
            ]);
        }

        $relationship = $this->translateRelationship($path, $person1->id, $person2->id);

        return response()->json([
            'found' => true,
            'person1' => $person1->full_name,
            'person2' => $person2->full_name,
            'path' => $path,
            'relationship' => $relationship
        ]);
    }

    /**
     * Build family graph from database
     */
    private function buildGraph()
    {
        $graph = [];

        $individuals = Individual::all();
        foreach ($individuals as $ind) {
            $graph[$ind->id] = [];
        }

        $relationships = Relationship::all();
        foreach ($relationships as $rel) {
            if ($rel->father_id) {
                $graph[$rel->child_id][] = $rel->father_id;
                $graph[$rel->father_id][] = $rel->child_id;
            }
            if ($rel->mother_id) {
                $graph[$rel->child_id][] = $rel->mother_id;
                $graph[$rel->mother_id][] = $rel->child_id;
            }
        }

        $marriages = Marriage::where('status', 'married')->get();
        foreach ($marriages as $marriage) {
            $graph[$marriage->husband_id][] = $marriage->wife_id;
            $graph[$marriage->wife_id][] = $marriage->husband_id;
        }

        foreach ($graph as $key => $value) {
            $graph[$key] = array_unique($value);
        }

        return $graph;
    }

    /**
     * BFS algorithm to find shortest path
     */
    private function bfs($graph, $start, $end)
    {
        $queue = [[$start]];
        $visited = [$start];

        while (!empty($queue)) {
            $path = array_shift($queue);
            $last = end($path);

            if ($last == $end) {
                return $path;
            }

            if (!isset($graph[$last])) {
                continue;
            }

            foreach ($graph[$last] as $neighbor) {
                if (!in_array($neighbor, $visited)) {
                    $visited[] = $neighbor;
                    $newPath = $path;
                    $newPath[] = $neighbor;
                    $queue[] = $newPath;
                }
            }
        }

        return null;
    }

    /**
     * Translate path to human-readable relationship
     */
    private function translateRelationship($path, $person1Id, $person2Id)
    {
        $count = count($path);

        // ============================================================
        // HUBUNGAN LANGSUNG (2 langkah)
        // ============================================================
        if ($count == 2) {
            $id1 = $path[0];
            $id2 = $path[1];

            $marriage = Marriage::where(function ($q) use ($id1, $id2) {
                $q->where('husband_id', $id1)->where('wife_id', $id2);
            })->orWhere(function ($q) use ($id1, $id2) {
                $q->where('husband_id', $id2)->where('wife_id', $id1);
            })->first();

            if ($marriage) {
                $person1 = Individual::find($id1);
                $person2 = Individual::find($id2);
                $gender = $person1->gender == 'male' ? 'Suami' : 'Istri';
                return "{$person1->full_name} adalah {$gender} dari {$person2->full_name}";
            }

            $rel = Relationship::where('child_id', $id2)->where('father_id', $id1)->first();
            if ($rel) {
                $person1 = Individual::find($id1);
                $person2 = Individual::find($id2);
                return "{$person1->full_name} adalah ayah dari {$person2->full_name}";
            }

            $rel = Relationship::where('child_id', $id2)->where('mother_id', $id1)->first();
            if ($rel) {
                $person1 = Individual::find($id1);
                $person2 = Individual::find($id2);
                return "{$person1->full_name} adalah ibu dari {$person2->full_name}";
            }

            $rel = Relationship::where('child_id', $id1)->where('father_id', $id2)->first();
            if ($rel) {
                $person1 = Individual::find($id1);
                $person2 = Individual::find($id2);
                return "{$person1->full_name} adalah anak dari {$person2->full_name}";
            }

            $rel = Relationship::where('child_id', $id1)->where('mother_id', $id2)->first();
            if ($rel) {
                $person1 = Individual::find($id1);
                $person2 = Individual::find($id2);
                return "{$person1->full_name} adalah anak dari {$person2->full_name}";
            }
        }

        // ============================================================
        // HUBUNGAN KOMPLEKS (3+ langkah)
        // ============================================================
        $nodes = [];
        foreach ($path as $id) {
            $nodes[] = Individual::find($id);
        }

        // ============================================================
        // DETEKSI: Kakek/Nenek (A → B → C)
        // ============================================================
        if ($count == 3) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];

            if ($this->isParent($a->id, $b->id) && $this->isParent($b->id, $c->id)) {
                $gender = $a->gender == 'male' ? 'Kakek' : 'Nenek';
                return "{$a->full_name} adalah {$gender} dari {$c->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Cucu (A → B → C)
        // ============================================================
        if ($count == 3) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];

            if ($this->isParent($c->id, $b->id) && $this->isParent($b->id, $a->id)) {
                $gender = $a->gender == 'male' ? 'Cucu laki-laki' : 'Cucu perempuan';
                return "{$a->full_name} adalah {$gender} dari {$c->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Paman/Bibi (A → B → C) - 3 langkah
        // ============================================================
        if ($count == 3) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];

            if ($this->areSiblings($a->id, $b->id) && $this->isParent($b->id, $c->id)) {
                $gender = $a->gender == 'male' ? 'Paman' : 'Bibi';
                return "{$a->full_name} adalah {$gender} dari {$c->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Paman/Bibi (A → B → C → D) - 4 langkah
        // ============================================================
        if ($count == 4) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];
            $d = $nodes[3];

            if ($this->isParent($b->id, $a->id) && $this->isParent($b->id, $c->id) && $this->isParent($c->id, $d->id) && $a->id != $c->id) {
                $gender = $a->gender == 'male' ? 'Paman' : 'Bibi';
                return "{$a->full_name} adalah {$gender} dari {$d->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Keponakan (A → B → C → D)
        // ============================================================
        if ($count == 4) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];
            $d = $nodes[3];

            if ($this->isParent($b->id, $a->id) && $this->isParent($b->id, $c->id) && $this->isParent($a->id, $d->id) && $a->id != $c->id) {
                $gender = $d->gender == 'male' ? 'Keponakan laki-laki' : 'Keponakan perempuan';
                return "{$d->full_name} adalah {$gender} dari {$c->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Saudara Kandung (A → B → C)
        // ============================================================
        if ($count == 3) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];

            $aParents = $this->getParents($a->id);
            $cParents = $this->getParents($c->id);

            $sameParent = false;
            foreach ($aParents as $aParent) {
                foreach ($cParents as $cParent) {
                    if ($aParent == $cParent) {
                        $sameParent = true;
                        break;
                    }
                }
            }

            if ($sameParent && $a->id != $c->id) {
                $gender = $a->gender == 'male' ? 'Saudara laki-laki' : 'Saudara perempuan';
                return "{$a->full_name} adalah {$gender} dari {$c->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Menantu (A → B → C)
        // ============================================================
        if ($count == 3) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];

            if ($this->areMarried($a->id, $b->id) && $this->isParent($c->id, $b->id)) {
                $gender = $a->gender == 'male' ? 'Menantu laki-laki' : 'Menantu perempuan';
                return "{$a->full_name} adalah {$gender} dari {$c->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Mertua (A → B → C)
        // ============================================================
        if ($count == 3) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];

            if ($this->areMarried($a->id, $b->id) && $this->isParent($c->id, $b->id)) {
                $gender = $c->gender == 'male' ? 'Mertua laki-laki' : 'Mertua perempuan';
                return "{$c->full_name} adalah {$gender} dari {$a->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Sepupu (A → B → C → D)
        // ============================================================
        if ($count == 4) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];
            $d = $nodes[3];

            $aHasChild = Relationship::where('father_id', $a->id)
                ->orWhere('mother_id', $a->id)
                ->exists();

            if ($this->isParent($b->id, $a->id) && $this->isParent($b->id, $c->id) && $this->isParent($c->id, $d->id) && $a->id != $c->id && $aHasChild) {
                $gender = $d->gender == 'male' ? 'Sepupu laki-laki' : 'Sepupu perempuan';
                return "{$d->full_name} adalah {$gender} dari {$a->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Ipar (A → B → C) - 3 langkah
        // ============================================================
        if ($count == 3) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];

            if ($this->areMarried($a->id, $b->id) && $this->areSiblings($b->id, $c->id)) {
                $gender = $c->gender == 'male' ? 'Ipar laki-laki' : 'Ipar perempuan';
                return "{$c->full_name} adalah {$gender} dari {$a->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Ipar (A → B → C → D) - 4 langkah (A dan B saudara, B nikah C, C dan D saudara)
        // ============================================================
        if ($count == 4) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];
            $d = $nodes[3];

            if ($this->areSiblings($a->id, $b->id) && $this->areMarried($b->id, $c->id) && $this->areSiblings($c->id, $d->id)) {
                $gender = $d->gender == 'male' ? 'Ipar laki-laki' : 'Ipar perempuan';
                return "{$d->full_name} adalah {$gender} dari {$a->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Ipar (A → B → C → D) - 4 langkah (A nikah B, B dan C saudara, C nikah D)
        // ============================================================
        if ($count == 4) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];
            $d = $nodes[3];

            if ($this->areMarried($a->id, $b->id) && $this->areSiblings($b->id, $c->id) && $this->areMarried($c->id, $d->id)) {
                $gender = $d->gender == 'male' ? 'Ipar laki-laki' : 'Ipar perempuan';
                return "{$d->full_name} adalah {$gender} dari {$a->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Ipar (A → B → C → D → E) - 5 langkah
        // ============================================================
        if ($count == 5) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];
            $d = $nodes[3];
            $e = $nodes[4];

            if ($this->areSiblings($a->id, $b->id) &&
                $this->areMarried($b->id, $c->id) &&
                $this->areSiblings($c->id, $d->id) &&
                $this->areMarried($d->id, $e->id)) {
                $gender = $e->gender == 'male' ? 'Ipar laki-laki' : 'Ipar perempuan';
                return "{$e->full_name} adalah {$gender} dari {$a->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Sepupu 2x (A → B → C → D → E) - 5 langkah
        // ============================================================
        if ($count == 5) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];
            $d = $nodes[3];
            $e = $nodes[4];

            $aHasChild = Relationship::where('father_id', $a->id)
                ->orWhere('mother_id', $a->id)
                ->exists();

            if ($this->isParent($b->id, $a->id) &&
                $this->isParent($b->id, $c->id) &&
                $this->isParent($c->id, $d->id) &&
                $this->isParent($d->id, $e->id) &&
                $a->id != $c->id &&
                $aHasChild) {
                $gender = $e->gender == 'male' ? 'Sepupu 2x laki-laki' : 'Sepupu 2x perempuan';
                return "{$e->full_name} adalah {$gender} dari {$a->full_name}";
            }
        }

        // ============================================================
        // DETEKSI: Besan (A → B → C → D) - 4 langkah
        // ============================================================
        if ($count == 4) {
            $a = $nodes[0];
            $b = $nodes[1];
            $c = $nodes[2];
            $d = $nodes[3];

            if ($this->areMarried($a->id, $b->id) &&
                $this->isParent($c->id, $b->id) &&
                $this->areMarried($c->id, $d->id)) {
                $gender = $d->gender == 'male' ? 'Besan laki-laki' : 'Besan perempuan';
                return "{$d->full_name} adalah {$gender} dari {$a->full_name}";
            }
        }

        // ============================================================
        // DEFAULT: Tampilkan jalur
        // ============================================================
        $relationships = [];
        for ($i = 0; $i < count($path) - 1; $i++) {
            $current = Individual::find($path[$i]);
            $next = Individual::find($path[$i + 1]);

            $rel = Relationship::where('child_id', $path[$i + 1])->where('father_id', $path[$i])->first();
            if ($rel) {
                $relationships[] = "{$current->full_name} (ayah dari {$next->full_name})";
                continue;
            }

            $rel = Relationship::where('child_id', $path[$i + 1])->where('mother_id', $path[$i])->first();
            if ($rel) {
                $relationships[] = "{$current->full_name} (ibu dari {$next->full_name})";
                continue;
            }

            $rel = Relationship::where('child_id', $path[$i])->where('father_id', $path[$i + 1])->first();
            if ($rel) {
                $relationships[] = "{$current->full_name} (anak dari {$next->full_name})";
                continue;
            }

            $rel = Relationship::where('child_id', $path[$i])->where('mother_id', $path[$i + 1])->first();
            if ($rel) {
                $relationships[] = "{$current->full_name} (anak dari {$next->full_name})";
                continue;
            }

            $marriage = Marriage::where('husband_id', $path[$i])->where('wife_id', $path[$i + 1])->first();
            if ($marriage) {
                $relationships[] = "{$current->full_name} (suami dari {$next->full_name})";
                continue;
            }

            $marriage = Marriage::where('husband_id', $path[$i + 1])->where('wife_id', $path[$i])->first();
            if ($marriage) {
                $relationships[] = "{$current->full_name} (istri dari {$next->full_name})";
                continue;
            }
        }

        $text = "Jalur hubungan: " . implode(" → ", array_map(function ($item) {
            return explode(' ', $item)[0];
        }, $relationships));

        return $text;
    }

    /**
     * Cek apakah A adalah orang tua dari B
     */
    private function isParent($parentId, $childId)
    {
        return Relationship::where('child_id', $childId)
            ->where(function ($q) use ($parentId) {
                $q->where('father_id', $parentId)
                  ->orWhere('mother_id', $parentId);
            })->exists();
    }

    /**
     * Dapatkan ID orang tua dari seseorang
     */
    private function getParents($individualId)
    {
        $parents = [];
        $rel = Relationship::where('child_id', $individualId)->first();
        if ($rel) {
            if ($rel->father_id) $parents[] = $rel->father_id;
            if ($rel->mother_id) $parents[] = $rel->mother_id;
        }
        return $parents;
    }

    /**
     * Cek apakah dua orang adalah saudara kandung
     */
    private function areSiblings($id1, $id2)
    {
        if ($id1 == $id2) return false;

        $parents1 = $this->getParents($id1);
        $parents2 = $this->getParents($id2);

        foreach ($parents1 as $p1) {
            foreach ($parents2 as $p2) {
                if ($p1 == $p2) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Cek apakah dua orang adalah pasangan suami-istri
     */
    private function areMarried($id1, $id2)
    {
        if ($id1 == $id2) return false;

        return Marriage::where(function ($q) use ($id1, $id2) {
            $q->where('husband_id', $id1)->where('wife_id', $id2);
        })->orWhere(function ($q) use ($id1, $id2) {
            $q->where('husband_id', $id2)->where('wife_id', $id1);
        })->exists();
    }

    /**
     * Display silsilah for a specific individual
     */
    public function show($id)
    {
        $individual = Individual::findOrFail($id);
        $allIndividuals = Individual::orderBy('first_name')->get();

        $tree = $this->buildFullTree($individual);

        return view('silsilah.show', compact('tree', 'individual', 'allIndividuals'));
    }

    /**
     * Build full tree (up and down) for a specific individual
     */
    private function buildFullTree($individual, $processedIds = [])
    {
        if (!$individual || in_array($individual->id, $processedIds)) {
            return null;
        }

        $processedIds[] = $individual->id;

        $parents = Relationship::where('child_id', $individual->id)->first();
        $fatherNode = null;
        $motherNode = null;

        if ($parents) {
            if ($parents->father_id) {
                $father = Individual::find($parents->father_id);
                if ($father && !in_array($father->id, $processedIds)) {
                    $fatherNode = $this->buildFullTree($father, $processedIds);
                }
            }
            if ($parents->mother_id) {
                $mother = Individual::find($parents->mother_id);
                if ($mother && !in_array($mother->id, $processedIds)) {
                    $motherNode = $this->buildFullTree($mother, $processedIds);
                }
            }
        }

        $spouse = null;
        $marriage = Marriage::where('husband_id', $individual->id)
            ->orWhere('wife_id', $individual->id)
            ->where('status', 'married')
            ->first();

        if ($marriage) {
            if ($marriage->husband_id == $individual->id) {
                $spouse = Individual::find($marriage->wife_id);
            } else {
                $spouse = Individual::find($marriage->husband_id);
            }
        }

        $children = Relationship::where('father_id', $individual->id)
            ->orWhere('mother_id', $individual->id)
            ->get();

        $childNodes = [];
        foreach ($children as $child) {
            $childInd = Individual::find($child->child_id);
            if ($childInd && !in_array($childInd->id, $processedIds)) {
                $childNode = $this->buildFullTree($childInd, $processedIds);
                if ($childNode) {
                    $childNodes[] = $childNode;
                }
            }
        }

        usort($childNodes, function ($a, $b) {
            return strtotime($a['birth_date'] ?? '1970-01-01') - strtotime($b['birth_date'] ?? '1970-01-01');
        });

        $result = [
            'id' => $individual->id,
            'name' => $individual->full_name,
            'gender' => $individual->gender,
            'birth_date' => $individual->birth_date,
            'death_date' => $individual->death_date,
            'spouse' => $spouse ? [
                'id' => $spouse->id,
                'name' => $spouse->full_name,
                'gender' => $spouse->gender,
                'birth_date' => $spouse->birth_date,
                'death_date' => $spouse->death_date,
            ] : null,
            'children' => $childNodes
        ];

        if ($fatherNode || $motherNode) {
            $result['parents'] = [
                'father' => $fatherNode,
                'mother' => $motherNode
            ];
        }

        return $result;
    }
}
