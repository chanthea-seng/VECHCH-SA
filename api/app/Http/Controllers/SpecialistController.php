<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'unique:specialists,name'],
            'local_name' => ['required', 'string', 'unique:specialists,local_name']
        ]);

        $specialist = Specialist::create($validated);

        return response()->json([
            'results' => true,
            'message' => 'Specialist created successfully',
            'data' => $specialist
        ]);
    }

    // Admin : Status, appointment
    // Doctor:
    // uSER : Status
    public function index(Request $request)
    {
        $search = $request->input('search');

        $specialists = Specialist::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%")
                ->orWhere('local_name', 'like', "%$search%");
        })->limit(255)->get(['id', 'name', 'local_name']);

        return response()->json([
            'results' => true,
            'message' => 'Get specialists successfully',
            'data' => $specialists
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'unique:specialists,name,' . $id],
            'local_name' => ['required', 'string', 'unique:specialists,local_name,' . $id]
        ]);

        $specialist = Specialist::findOrFail($id);
        $specialist->update($validated);

        return response()->json([
            'results' => true,
            'message' => 'Specialist updated successfully',
            'data' => $specialist
        ]);
    }

    public function destroy($id)
    {
        $specialist = Specialist::findOrFail($id);
        $specialist->delete();

        return response()->json([
            'results' => true,
            'message' => 'Specialist deleted successfully'
        ]);
    }
}
