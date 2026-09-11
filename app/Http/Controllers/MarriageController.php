<?php

namespace App\Http\Controllers;

use App\Models\Individual;
use App\Models\Marriage;
use Illuminate\Http\Request;

class MarriageController extends Controller
{
    /**
     * Show form to add marriage for an individual
     */
    public function create($individualId)
    {
        $individual = Individual::findOrFail($individualId);
        $potentialSpouses = Individual::where('id', '!=', $individualId)
                                     ->orderBy('first_name')
                                     ->get();

        return view('marriages.create', compact('individual', 'potentialSpouses'));
    }

    /**
     * Store a new marriage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'husband_id' => 'required|exists:individuals,id',
            'wife_id' => 'required|exists:individuals,id|different:husband_id',
            'marriage_date' => 'nullable|date',
            'divorce_date' => 'nullable|date|after:marriage_date',
            'marriage_place' => 'nullable|string|max:255',
            'status' => 'required|in:married,divorced,widowed',
            'notes' => 'nullable|string',
        ]);

        // Check if marriage already exists
        $existing = Marriage::where('husband_id', $validated['husband_id'])
                           ->where('wife_id', $validated['wife_id'])
                           ->first();

        if ($existing) {
            return redirect()->back()
                            ->with('error', 'Pernikahan ini sudah tercatat!')
                            ->withInput();
        }

        $marriage = Marriage::create($validated);

        return redirect()->route('individuals.show', $validated['husband_id'])
                         ->with('success', 'Pernikahan berhasil ditambahkan!');
    }

    /**
     * Show form to edit marriage
     */
    public function edit(Marriage $marriage)
    {
        return view('marriages.edit', compact('marriage'));
    }

    /**
     * Update marriage
     */
    public function update(Request $request, Marriage $marriage)
    {
        $validated = $request->validate([
            'marriage_date' => 'nullable|date',
            'divorce_date' => 'nullable|date|after:marriage_date',
            'marriage_place' => 'nullable|string|max:255',
            'status' => 'required|in:married,divorced,widowed',
            'notes' => 'nullable|string',
        ]);

        $marriage->update($validated);

        return redirect()->route('individuals.show', $marriage->husband_id)
                         ->with('success', 'Pernikahan berhasil diupdate!');
    }

    /**
     * Delete marriage
     */
    public function destroy(Marriage $marriage)
    {
        $husbandId = $marriage->husband_id;
        $marriage->delete();

        return redirect()->route('individuals.show', $husbandId)
                         ->with('success', 'Pernikahan berhasil dihapus!');
    }
}
