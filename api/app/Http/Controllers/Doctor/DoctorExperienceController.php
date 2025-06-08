<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorExperience;
use App\Helpers\DateHelper;
use App\Http\Resources\ExperienceResource;

class DoctorExperienceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $experiences = DoctorExperience::where('user_id', $user->id)->orderBy('id', 'asc')->get();
        return response()->json([
            'result' => true,
            'message' => 'Experiences retrieved successfully',
            'data' => ExperienceResource::collection($experiences)
        ]);
    }

    public function find($id)
    {
        $experience = DoctorExperience::find($id);

        if (!$experience) {
            return response()->json(['message' => 'Experience record not found'], 404);
        }

        return response()->json([
            'result' => true,
            'message' => 'Experience retrieved successfully',
            'data' => new ExperienceResource($experience)
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
            'specialist_id' => ['nullable', 'integer', 'exists:specialists,id'],
            'organization_name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'responsibilities' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'is_current' => ['boolean'],
            'location' => ['required', 'string', 'max:255'],
            'is_verified' => ['boolean']
        ]);

        $isCurrent = $req->end_date ? false : true;

        $experience = new DoctorExperience();
        $experience->user_id = $user->id;
        $experience->specialist_id = $req->input('specialist_id');
        $experience->organization_name = $req->input('organization_name');
        $experience->position = $req->input('position');
        $experience->responsibilities = $req->input('responsibilities');
        $experience->start_date = $req->input('start_date');
        $experience->end_date = $req->input('end_date');
        $experience->is_current = $isCurrent;
        $experience->location = $req->input('location');
        $experience->is_verified = $req->input('is_verified', true);
        $experience->save();

        return response()->json([
            'result' => true,
            'message' => 'Experience record created successfully',
            'data' => new ExperienceResource($experience)
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

        $experience = DoctorExperience::find($id);
        if (!$experience) {
            return response()->json(['message' => 'Experience record not found'], 404);
        }

        if ($experience->user_id !== $user->id) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied'
            ], 403);
        }

        $req->validate([
            'specialist_id' => ['nullable', 'integer', 'exists:specialists,id'],
            'organization_name' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'responsibilities' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'is_current' => ['boolean'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_verified' => ['boolean']
        ]);

        $experience->specialist_id = $req->input('specialist_id');
        $experience->organization_name = $req->input('organization_name');
        $experience->position = $req->input('position');
        $experience->responsibilities = $req->input('responsibilities');
        $experience->start_date = $req->input('start_date');
        $experience->end_date = $req->input('end_date');
        $experience->is_current = $req->input('is_current', false);
        $experience->location = $req->input('location');
        $experience->is_verified = $req->input('is_verified', false);
        $experience->save();

        return response()->json([
            'result' => true,
            'message' => 'Experience record updated successfully',
            'data' => new ExperienceResource($experience)
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

        $experience = DoctorExperience::find($id);
        if (!$experience) {
            return response()->json(['message' => 'Experience record not found'], 404);
        }

        if ($experience->user_id !== $user->id) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied'
            ], 403);
        }

        $experience->delete();

        return response()->json([
            'result' => true,
            'message' => 'Experience record deleted successfully'
        ]);
    }
}
