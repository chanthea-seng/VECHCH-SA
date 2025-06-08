<?php

namespace App\Http\Controllers;

use App\Http\Resources\saveDoctorResource;
use App\Models\SaveDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaveDoctorController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Get saved doctors for the authenticated user
        $savedDoctors = SaveDoctor::with(['doctor', 'user'])
            ->where('user_id', $user->id)
            ->get();

        return response()->json([
            'result' => true,
            'message' => 'Get successful',
            'user' => [
                'id' => $user->id,
                'fullname' => $user->fullname,
                'local_fullname' => $user->local_fullname,
                'avatar' => asset(
                    $user->avatar && $user->avatar !== 'user/no_avatar.jpg'
                    ? 'storage/' . $user->avatar
                    : 'storage/user/no_avatar.jpg'
                ),
            ],
            'doctors' => $savedDoctors->map(function ($savedDoctor) {
                $doctor = $savedDoctor->doctor;
                $doctorProfile = $doctor->doctorProfile;

                return [
                    'id' => $doctor->id,
                    'fullname' => $doctor->fullname,
                    'local_fullname' => $doctor->local_fullname,
                    'avatar' => $doctor->avatar
                        ? asset('storage/' . $doctor->avatar)
                        : null,
                    'languages' => $doctorProfile && $doctorProfile->spoken_languages
                        ? json_decode($doctorProfile->spoken_languages, true)
                        : [],
                    'specialist' => $doctorProfile && $doctorProfile->specialist
                        ? [
                            'name' => $doctorProfile->specialist->name,
                            'local_name' => $doctorProfile->specialist->local_name,
                        ]
                        : null,
                    'department' => $doctorProfile && $doctorProfile->department
                        ? [
                            'name' => $doctorProfile->department->name,
                            'local_name' => $doctorProfile->department->local_name,
                        ]
                        : null,
                    'center' => $doctorProfile && $doctorProfile->center
                        ? [
                            'name' => $doctorProfile->center->name,
                            'local_name' => $doctorProfile->center->local_name,
                        ]
                        : null,
                ];
            })->values(), // Ensure array keys are reset
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => ['required', 'exists:users,id'],
        ]);

        $userId = Auth::id();

        if (SaveDoctor::where('user_id', $userId)->where('doctor_id', $validated['doctor_id'])->exists()) {
            return response()->json(['message' => 'Doctor already saved'], 409);
        }

        $saveDoctor = SaveDoctor::create([
            'user_id' => $userId,
            'doctor_id' => $validated['doctor_id'],
        ]);

        return response()->json([
            'message' => 'Doctor saved successfully',
            'data' => $saveDoctor
        ], 201);
    }

    public function destroy($doctor_id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $saveDoctor = SaveDoctor::where('user_id', Auth::id())
            ->where('doctor_id', $doctor_id)
            ->first();

        if (!$saveDoctor) {
            return response()->json(['message' => 'Saved doctor not found'], 404);
        }

        $saveDoctor->delete();
        return response()->json(null, 204);
    }
}
