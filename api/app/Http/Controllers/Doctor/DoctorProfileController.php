<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Doctor\DoctorFullResource;
use App\Models\DoctorProfile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Doctor\DoctorResource;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\This;

class DoctorProfileController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'result' => false,
                    'message' => 'Unauthorized to create a doctor profile.',
                ], 403);
            }

            $spoken_languages = json_decode($request->input('spoken_languages')) ?: [];
            $request->merge(['spoken_languages' => $spoken_languages]);
            $validated = $request->validate([
                'user_id' => ['required', 'integer', 'exists:users,id'],
                'biography' => ['nullable', 'string'],
                'spoken_languages' => ['nullable', 'array'],
                'specialist_id' => ['required', 'integer', 'exists:specialists,id'],
                'department_id' => ['required', 'integer', 'exists:departments,id'],
                'center_id' => ['required', 'integer', 'exists:centers,id'],
                'is_author' => ['boolean'],
            ]);

            if (isset($validated['spoken_languages'])) {
                $validated['spoken_languages'] = json_encode($validated['spoken_languages']);
            }

            // Check if doctor profile already exists
            if (DoctorProfile::where('user_id', $validated['user_id'])->exists()) {
                return response()->json([
                    'result' => false,
                    'message' => 'Doctor profile already exists.',
                ], 409);
            }

            // Create doctor profile
            $doctorProfile = new DoctorProfile();
            $doctorProfile->user_id = $validated['user_id'];
            $doctorProfile->biography = $validated['biography'] ?? null;
            $doctorProfile->spoken_languages = $validated['spoken_languages'];
            $doctorProfile->specialist_id = $validated['specialist_id'];
            $doctorProfile->department_id = $validated['department_id'];
            $doctorProfile->center_id = $validated['center_id'];
            $doctorProfile->is_author = $validated['is_author'] ?? false;
            $doctorProfile->save();

            return response()->json([
                'result' => true,
                'message' => 'Doctor profile created successfully.',
                'doctor_profile' => $doctorProfile,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to create doctor profile. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function find($id)
    {
        try {
            $doctorProfile = DoctorProfile::with([
                'user:id,fullname,local_fullname,avatar,gender,email,phone_number',
                'specialist:id,name,local_name',
                'department:id,name,local_name',
                'center:id,name,local_name',
            ])->where('user_id', $id)->first();

            return $this->res_success('get doctor success', new DoctorFullResource($doctorProfile));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Doctor profile not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'An error occurred while retrieving the doctor profile.'
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $validated = $request->validate([
                'search' => 'nullable|string|max:255',
                'specialist' => 'nullable|integer|exists:specialists,id',
                'per_page' => 'nullable|integer|min:1|max:100',
                'sort_by' => 'nullable|string|in:user_id,name,email',
                'order' => 'nullable|string|in:asc,desc',
                'is_verify' => 'nullable|boolean',
            ]);

            $search = $validated['search'] ?? null;
            $specialistId = $validated['specialist'] ?? null;
            $perPage = $validated['per_page'] ?? 15;
            $sortBy = $validated['sort_by'] ?? 'user_id';
            $order = $validated['order'] ?? 'asc';
            $order = in_array(strtolower($order), ['asc', 'desc']) ? $order : 'asc';

            $doctorProfiles = DoctorProfile::with([
                'user:id,fullname,local_fullname,avatar',
                'specialist:id,name,local_name',
                'department:id,name,local_name',
                'center:id,name,local_name',
            ])->whereHas('user', function ($query) {
                $query->where('role_id', 2);
            })
                ->when(filled($search), function ($query) use ($search) {
                    $query->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where(function ($q) use ($search) {
                            $q->where('fullname', 'LIKE', "%{$search}%")
                                ->orWhere('local_fullname', 'LIKE', "%{$search}%");
                        });
                    });
                })
                ->when(filled($specialistId), function ($query) use ($specialistId) {
                    $query->where('specialist_id', $specialistId);
                });

            if ($request->filled('is_verify')) {
                $doctorProfiles = $doctorProfiles
                    ->where("is_verify", intval($request->input('is_verify')));
            }
            $doctorProfiles = $doctorProfiles
                ->orderBy($sortBy, $order)
                ->paginate($perPage);
            return $this->res_paginate('get doctor', DoctorResource::collection($doctorProfiles), $doctorProfiles);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to retrieve doctor profiles.',
            ], 500);
        }
    }

    public function updateProfile(Request $req, $id)
    {
        $user = Auth::user();
        $doctorProfile = User::findOrFail($id);

        // Authorization check
        if ($user->role_id !== 1 && $user->id !== $doctorProfile->user_id) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized to update this profile.'
            ], 403);
        }
        try {
            // Validate request data
            $validated = $req->validate([
                'fullname' => 'sometimes|string|max:255',
                'local_fullname' => 'sometimes|string|max:255',
                'phone_number' => 'nullable|string|max:20',
                'avatar' => 'sometimes|file|mimetypes:image/png,image/jpeg|max:1048', // Fixed 'jep' to 'jpeg'
                'dob' => 'sometimes|date',
                'gender' => 'sometimes|in:male,female',
                'email' => ['required', 'string', 'max:255', Rule::unique('users', 'email')->ignore($doctorProfile->id)],
            ]);

            // Handle avatar upload
            $defaultAvatar = 'user/no_avatar.jpg';
            if ($req->hasFile('avatar')) {
                // Delete old avatar if it exists and isn’t default
                if ($doctorProfile->avatar && $doctorProfile->avatar !== $defaultAvatar) {
                    if (Storage::disk('public')->exists($doctorProfile->avatar)) {
                        Storage::disk('public')->delete($doctorProfile->avatar);
                    }
                }
                // Store new avatar
                $path = $req->file('avatar')->store('user', 'public');
                $validated['avatar'] = $path;
            }

            // Update the profile
            $doctorProfile->update($validated);

            // Refresh the model to get the latest data
            $doctorProfile->refresh();

            return response()->json([
                'result' => true,
                'message' => 'Profile updated successfully.',
                'data' => $doctorProfile
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'An error occurred while updating the profile.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            // dd($request->all());
            $user = Auth::user();
            $doctorProfile = DoctorProfile::findOrFail($id);
            if ($user->role_id !== 1 && $user->id !== $doctorProfile->user_id) {
                return response()->json([
                    'result' => false,
                    'message' => 'Unauthorized to update this profile.'
                ], 403);
            }
            $validated = $request->validate([
                'biography' => ['nullable', 'string'],
                'spoken_languages' => ['nullable', 'array'],
                'spoken_languages.*' => ['string'],
                'specialist_id' => ['required', 'integer', 'exists:specialists,id'],
                'department_id' => ['required', 'integer', 'exists:departments,id'],
                'center_id' => ['required', 'integer', 'exists:centers,id'],
                'is_author' => ['nullable', 'boolean'],
                'is_verify' => ['nullable', 'boolean'],
            ]);

            $validated['spoken_languages'] = json_encode($validated['spoken_languages'] ?? []);
            $doctorProfile->update($validated);

            return response()->json([
                'result' => true,
                'message' => 'Doctor profile updated successfully.',
                'doctor_profile' => $doctorProfile->refresh()
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update doctor profile. ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $doctorProfile = DoctorProfile::findOrFail($id);

            if (!$user->hasRole('Admin')) {
                return response()->json([
                    'result' => false,
                    'message' => 'Unauthorized to delete this profile.'
                ], 403);
            }

            $doctorProfile->delete();
            return response()->json([
                'result' => true,
                'message' => 'Doctor profile deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to remove doctor profile. ' . $e->getMessage()
            ], 500);
        }
    }

    // ============= biography =============
    public function getBiography()
    {
        $user = Auth::user(); // Get authenticated user

        $doctorProfile = DoctorProfile::where('user_id', $user->id)->first();

        return response()->json([
            'result' => true,
            'message' => 'Biography get successfully',
            'biography' => $doctorProfile->biography
        ], 200);
    }

    public function updateBiography(Request $request)
    {
        $request->validate([
            'biography' => ['nullable', 'string', 'max:1000'],
        ]);
        $user = Auth::user();

        $doctorProfile = DoctorProfile::where('user_id', $user->id)->first();
        $doctorProfile->update(['biography' => $request->biography]);

        return response()->json([
            'result' => true,
            'message' => 'Biography updated successfully',
            'data' => $doctorProfile->biography
        ], 200);
    }
}
