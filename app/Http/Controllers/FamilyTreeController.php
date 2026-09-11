<?php

namespace App\Http\Controllers;

use App\Models\Individual;
use App\Models\Marriage;
use App\Models\Relationship;
use Illuminate\Http\Request;

class FamilyTreeController extends Controller
{
    public function index()
    {
        $individuals = Individual::all();
        return view('family-tree.index', compact('individuals'));
    }

    public function getTreeData(Request $request)
    {
        $rootId = $request->input('root_id');

        if (!$rootId) {
            $root = Individual::first();
            if (!$root) {
                return response()->json(['nodes' => [], 'edges' => []]);
            }
            $rootId = $root->id;
        }

        $nodes = [];
        $edges = [];
        $processedIds = [];
        $levelMap = [];

        $this->buildTreeData($rootId, $nodes, $edges, $processedIds, $levelMap, 0);

        return response()->json([
            'nodes' => $nodes,
            'edges' => $edges
        ]);
    }

    private function buildTreeData($individualId, &$nodes, &$edges, &$processedIds, &$levelMap, $level = 0)
    {
        if (in_array($individualId, $processedIds)) {
            return;
        }

        $individual = Individual::find($individualId);
        if (!$individual) {
            return;
        }

        $processedIds[] = $individualId;

        // Add individual as node
        $nodes[] = [
            'id' => $individual->id,
            'label' => $individual->full_name,
            'title' => $individual->full_name . "\n" .
                       ($individual->gender == 'male' ? 'Laki-laki' : 'Perempuan') .
                       ($individual->birth_date ? "\nLahir: " . date('d/m/Y', strtotime($individual->birth_date)) : ''),
            'shape' => $individual->gender == 'male' ? 'box' : 'ellipse',
            'color' => $individual->gender == 'male' ? '#4A90D9' : '#E91E63',
            'font' => ['color' => 'white', 'size' => 14],
            'level' => $level
        ];

        $levelMap[$individual->id] = $level;

        // Get spouse
        $marriage = Marriage::where('husband_id', $individualId)
                            ->orWhere('wife_id', $individualId)
                            ->first();

        if ($marriage) {
            $spouseId = $marriage->husband_id == $individualId ? $marriage->wife_id : $marriage->husband_id;

            if (!in_array($spouseId, $processedIds)) {
                $spouse = Individual::find($spouseId);
                if ($spouse) {
                    $nodes[] = [
                        'id' => $spouse->id,
                        'label' => $spouse->full_name,
                        'title' => $spouse->full_name . "\n" .
                                   ($spouse->gender == 'male' ? 'Laki-laki' : 'Perempuan') .
                                   ($spouse->birth_date ? "\nLahir: " . date('d/m/Y', strtotime($spouse->birth_date)) : ''),
                        'shape' => $spouse->gender == 'male' ? 'box' : 'ellipse',
                        'color' => $spouse->gender == 'male' ? '#4A90D9' : '#E91E63',
                        'font' => ['color' => 'white', 'size' => 14],
                        'level' => $level
                    ];

                    // Edge: husband - wife (marriage)
                    $edges[] = [
                        'from' => $individualId,
                        'to' => $spouseId,
                        'color' => '#FF6B6B',
                        'dashes' => true,
                        'width' => 2,
                        'title' => 'Menikah'
                    ];

                    $processedIds[] = $spouseId;
                    $levelMap[$spouseId] = $level;
                }
            }
        }

        // Get children
        $children = Relationship::where('father_id', $individualId)
                                ->orWhere('mother_id', $individualId)
                                ->get();

        foreach ($children as $child) {
            if (!in_array($child->child_id, $processedIds)) {
                // Edge: parent - child
                $edges[] = [
                    'from' => $individualId,
                    'to' => $child->child_id,
                    'arrows' => 'to',
                    'color' => '#AAAAAA',
                    'width' => 2,
                    'smooth' => ['type' => 'cubicBezier', 'roundness' => 0.1]
                ];

                $this->buildTreeData($child->child_id, $nodes, $edges, $processedIds, $levelMap, $level + 1);
            }
        }
    }
}
