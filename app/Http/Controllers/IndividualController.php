<?php

namespace App\Http\Controllers;

use App\Models\Individual;
use App\Models\Marriage;
use App\Models\Relationship;
use Illuminate\Http\Request;

class IndividualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $individuals = Individual::orderBy('first_name')->paginate(20);
        return view('individuals.index', compact('individuals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $individuals = Individual::orderBy('first_name')->get();
        return view('individuals.create', compact('individuals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'death_date' => 'nullable|date|after:birth_date',
            'death_place' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'father_id' => 'nullable|exists:individuals,id',
            'mother_id' => 'nullable|exists:individuals,id',
        ]);

        // Create individual
        $individual = Individual::create($validated);

        // If father and mother are provided, create relationship
        if ($request->filled('father_id') && $request->filled('mother_id')) {
            // Check if marriage exists
            $marriage = Marriage::where('husband_id', $request->father_id)
                                ->where('wife_id', $request->mother_id)
                                ->first();

            if (!$marriage) {
                // Create marriage if not exists
                $marriage = Marriage::create([
                    'husband_id' => $request->father_id,
                    'wife_id' => $request->mother_id,
                    'status' => 'married'
                ]);
            }

            // Create relationship
            Relationship::create([
                'child_id' => $individual->id,
                'father_id' => $request->father_id,
                'mother_id' => $request->mother_id,
                'marriage_id' => $marriage->id,
                'relationship_type' => 'biological'
            ]);
        } elseif ($request->filled('father_id')) {
            // Only father provided
            Relationship::create([
                'child_id' => $individual->id,
                'father_id' => $request->father_id,
                'mother_id' => null,
                'relationship_type' => 'biological'
            ]);
        } elseif ($request->filled('mother_id')) {
            // Only mother provided
            Relationship::create([
                'child_id' => $individual->id,
                'father_id' => null,
                'mother_id' => $request->mother_id,
                'relationship_type' => 'biological'
            ]);
        }

        return redirect()->route('individuals.index')
                         ->with('success', 'Individu berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Individual $individual)
    {
        // Load relationships
        $individual->load(['childrenAsFather', 'childrenAsMother', 'marriagesAsHusband', 'marriagesAsWife']);

        // Get children
        $children = $individual->children();

        // Get spouse
        $spouse = $individual->spouse();

        // Get parents
        $parents = Relationship::where('child_id', $individual->id)->first();

        return view('individuals.show', compact('individual', 'children', 'spouse', 'parents'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Individual $individual)
    {
        $allIndividuals = Individual::where('id', '!=', $individual->id)->orderBy('first_name')->get();

        // Get current parents
        $relationship = Relationship::where('child_id', $individual->id)->first();

        return view('individuals.edit', compact('individual', 'allIndividuals', 'relationship'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Individual $individual)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'death_date' => 'nullable|date|after:birth_date',
            'death_place' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'father_id' => 'nullable|exists:individuals,id',
            'mother_id' => 'nullable|exists:individuals,id',
        ]);

        $individual->update($validated);

        // Update relationship if father or mother provided
        if ($request->filled('father_id') || $request->filled('mother_id')) {
            $relationship = Relationship::where('child_id', $individual->id)->first();

            if (!$relationship) {
                $relationship = new Relationship();
                $relationship->child_id = $individual->id;
            }

            $relationship->father_id = $request->father_id;
            $relationship->mother_id = $request->mother_id;
            $relationship->relationship_type = 'biological';
            $relationship->save();

            // If both parents exist, create marriage if not exists
            if ($request->filled('father_id') && $request->filled('mother_id')) {
                $marriage = Marriage::where('husband_id', $request->father_id)
                                    ->where('wife_id', $request->mother_id)
                                    ->first();

                if (!$marriage) {
                    Marriage::create([
                        'husband_id' => $request->father_id,
                        'wife_id' => $request->mother_id,
                        'status' => 'married'
                    ]);
                }
            }
        }

        return redirect()->route('individuals.index')
                         ->with('success', 'Individu berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Individual $individual)
    {
        // Delete related records first
        Relationship::where('child_id', $individual->id)->delete();
        Relationship::where('father_id', $individual->id)->delete();
        Relationship::where('mother_id', $individual->id)->delete();
        Marriage::where('husband_id', $individual->id)->delete();
        Marriage::where('wife_id', $individual->id)->delete();

        $individual->delete();

        return redirect()->route('individuals.index')
                         ->with('success', 'Individu berhasil dihapus!');
    }
}
