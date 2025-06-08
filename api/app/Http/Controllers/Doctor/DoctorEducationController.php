<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorEducation;
use App\Http\Controllers\Controller;

class DoctorEducationController extends Controller
{
    public function index(Request $req)
    {
        $user = Auth::user();

        $query = DoctorEducation::query();

        $educations = $query->where('user_id', $user->id)->orderBy('id', 'asc')->get();

        return response()->json([
            'result' => true,
            'message' => 'Educations retrieved successfully',
            'data' => $educations
        ]);
    }

    public function find($id)
    {
        $education = DoctorEducation::find($id);

        if (!$education) {
            return response()->json(['message' => 'Education record not found'], 404);
        }

        return response()->json([
            'result' => true,
            'message' => 'Education retrieved successfully',
            'data' => $education
        ]);
    }

    public function store(Request $req)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $req->validate([
            'institution_name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'degree_name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
        ]);

        $education = new DoctorEducation();
        $education->user_id = $user->id;
        $education->institution_name = $req->input('institution_name');
        $education->location = $req->input('location');
        $education->degree_name = $req->input('degree_name');
        $education->start_date = $req->input('start_date');
        $education->end_date = $req->input('end_date');
        $education->save();

        return response()->json([
            'result' => true,
            'message' => 'Education record created successfully',
            'data' => $education
        ]);
    }

    public function update(Request $req, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $education = DoctorEducation::find($id);
        if (!$education) {
            return response()->json(['message' => 'Education record not found'], 404);
        }

        if ($education->user_id !== $user->id) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied'
            ], 403);
        }

        $req->validate([
            'institution_name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'degree_name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
        ]);

        $education->institution_name = $req->input('institution_name');
        $education->location = $req->input('location');
        $education->degree_name = $req->input('degree_name');
        $education->start_date = $req->input('start_date');
        $education->end_date = $req->input('end_date');
        $education->save();

        return response()->json([
            'result' => true,
            'message' => 'Education record updated successfully',
            'data' => $education
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $education = DoctorEducation::find($id);
        if (!$education) {
            return response()->json(['message' => 'Education record not found'], 404);
        }

        if ($education->user_id !== $user->id) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied'
            ], 403);
        }

        $education->delete();

        return response()->json([
            'result' => true,
            'message' => 'Education record deleted successfully'
        ]);
    }
}
