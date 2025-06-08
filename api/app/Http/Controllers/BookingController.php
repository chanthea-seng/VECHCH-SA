<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Booking\BookingFullResource;
use App\Models\Booking;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Booking\BookingCardResource;
use App\Http\Resources\Booking\BookingMiniCardResource;
use App\Http\Resources\Booking\RelateBookingResource;
use App\Models\Article;
use App\Models\Contact;
use App\Models\Service;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\BookingConfirmedNotification;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role_id !== 3) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized: Only users can create bookings'
            ], 403);
        }

        $rateLimitKey = 'booking_attempt:' . $user->id;
        if (!Cache::has($rateLimitKey)) {
            Cache::put($rateLimitKey, 1, now()->addMinutes(1));
        } else {
            Cache::increment($rateLimitKey);
        }

        $attempts = Cache::get($rateLimitKey, 0);

        if ($attempts > 5) {
            return response()->json([
                'result' => false,
                'error' => 'Too many booking attempts. Please try again later.'
            ], 429);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'local_name' => ['required', 'string', 'max:255'],
            'dob' => ['nullable', 'date', 'before:today'],
            'gender' => ['required', 'in:0,1,2,3'],
            'phone_number' => ['required', 'string', 'max:15'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'doctor_id' => ['nullable', 'exists:users,id'],
            'service_type' => ['required', 'integer', 'min:0', 'max:2'],
            'sub_service_id' => ['nullable', 'exists:sub_services,id'],
            'appointment_time' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'paymentImage' => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048']
        ]);

        try {
            $bookingData = $request->all();
            $bookingData['user_id'] = $user->id;
            $bookingData['booking_status'] = 0;
            if ($request->filled('service_type')) {
                $tem = $request->input('service_type');
                if ($tem != 0)
                    $bookingData['booking_status'] = 1;
            }

            // if ($request->hasFile('file')) {
            //     $bookingData['file'] = $request->file('file')->store('bookings', 'public');
            // }
            // if ($request->hasFile('paymentImage')) {
            //     $bookingData['paymentImage'] = $request->file('paymentImage')->store('bookings', 'public');
            // }
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $file->hashName();
                $file->storeAs('bookings', $fileName, 'local');
                $bookingData['file'] = $fileName;
            }

            if ($request->hasFile('paymentImage')) {
                $paymentImage = $request->file('paymentImage');
                $paymentImageName = $paymentImage->hashName();
                $paymentImage->storeAs('bookings', $paymentImageName, 'local');
                $bookingData['paymentImage'] = $paymentImageName;
            }

            $booking = Booking::create($bookingData);
            if ($booking->service_type != 0) {
                Notification::create([
                    'user_id' => $booking->user_id,
                    'booking_id' => $booking->id,
                    'title' => 'ការកក់ដោយជោគជ័យ',
                    'type' => 2,
                    'message' => 'អ្នកអាចពិនិត្យមើលវិក្កយបត្ររបស់អ្នកនៅក្នុងគណនីរបស់អ្នក',
                ]);
            }

            Cache::forget($rateLimitKey);

            return $this->res_success('Create booking Successfully', new BookingCardResource($booking));
        } catch (\Exception $e) {
            if (isset($bookingData['file']) && Storage::disk('public')->exists($bookingData['file'])) {
                Storage::disk('public')->delete($bookingData['file']);
            }

            return response()->json([
                'result' => false,
                'error' => 'Booking creation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $service_type = $request->input('service_type', null);
        $booking_status = $request->input('booking_status', null);

        foreach (['service_type', 'booking_status'] as $field) {
            $$field = $request->input($field, null);

            if (is_string($$field)) {
                $decoded = json_decode($$field, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $$field = $decoded;
                }
            }
            if (is_numeric($$field)) {
                $$field = [(int) $$field];
            }

            $$field = is_array($$field) ? $$field : null;

            $request->merge([$field => $$field]);
        }

        $request->validate([
            'doctor_id' => ['nullable', 'min:1', 'exists:users,id'],
            'booking_status' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (is_null($value) || $value === []) {
                        return; // Allows null or an empty array
                    }

                    if (!is_array($value)) {
                        $fail("$attribute must be an array or a single integer.");
                        return;
                    }

                    foreach ($value as $item) {
                        if (!is_numeric($item) || !in_array($item, [0, 1, 2, 3])) {
                            $fail("Each $attribute must be an integer between 0 and 3.");
                        }
                    }
                },
            ],
            'appointment_time' => ['nullable', 'date'],
            'name' => ['nullable', 'string', 'max:50'],
            'local_name' => ['nullable', 'string', 'max:50'],
            'search' => ['nullable', 'string', 'min:1', 'max:250'],
            'scol' => ['nullable', 'string', 'min:0', 'in:appointment_time,id,created_at'],
            'sdir' => ['nullable', 'string', 'in:desc,asc'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'is_complete' => ['nullable', 'boolean'],
            'is_remove' => ['nullable', 'boolean'],
            'service_type' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (is_null($value) || $value === []) {
                        return; // Allows null or an empty array
                    }

                    if (!is_array($value)) {
                        $fail("$attribute must be an array or a single integer.");
                        return;
                    }

                    foreach ($value as $item) {
                        if (!is_numeric($item) || $item < 0 || $item > 2) {
                            $fail("Each $attribute must be an integer between 0 and 2.");
                        }
                    }
                },
            ],
            ['today' => ['nullable', 'boolean']]
        ]);
        $scol = $request->input('scol', 'id');
        $sdir = $request->input('sdir', 'desc');
        $per_page = $request->input('per_page', 10);

        $query = Booking::query()->with(['user', 'doctor', 'subService']);
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized: Authentication required.'
            ], 403);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('local_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($y) use ($search) {
                        $y->where('fullname', 'like', "%{$search}%")
                            ->orWhere('local_fullname', 'like', "%{$search}%");
                    })
                    ->orWhereHas('doctor', function ($y) use ($search) {
                        $y->where('fullname', 'like', "%{$search}%")
                            ->orWhere('local_fullname', 'like', "%{$search}%");
                    });
            });
        }

        switch ($user->role_id) {
            case 1: // Admin
                if ($request->filled('name') || $request->filled('local_name')) {
                    $query->where(function ($q) use ($request) {
                        if ($request->filled('name')) {
                            $q->where('name', 'like', '%' . $request->input('name') . '%');
                        }
                        if ($request->filled('local_name')) {
                            $q->orWhere('local_name', 'like', '%' . $request->input('local_name') . '%');
                        }
                    });
                }
                break;

            case 2: // Doctor
                $query->where('doctor_id', $user->id);
                if ($request->filled('name')) {
                    $query->where('name', 'like', '%' . $request->input('name') . '%');
                }
                if ($request->filled('local_name')) {
                    $query->orWhere('local_name', 'like', '%' . $request->input('local_name') . '%');
                }
                break;

            case 3: // Patient
                $query->where('user_id', $user->id)->where('is_remove', false);
                if ($request->filled('doctor_id')) {
                    $query->where('doctor_id', $request->input('doctor_id'));
                }
                if ($request->filled('name')) {
                    $query->whereHas('doctor', function ($q) use ($request) {
                        $q->where('fullname', 'like', '%' . $request->input('name') . '%');
                    });
                    if ($request->filled('local_name')) {
                        $query->orWhere('local_name', 'like', '%' . $request->input('local_name') . '%');
                    }
                }
                break;

            default:
                return response()->json([
                    'result' => false,
                    'error' => 'Unauthorized: Invalid role'
                ], 403);
        }

        if ($request->filled('appointment_time')) {
            $query->whereDate('appointment_time', $request->input('appointment_time'));
        }

        if ($request->filled('is_complete')) {
            $query->where('is_complete', $request->input('is_complete'));
        }

        if ($request->filled('is_remove')) {
            $query->where('is_remove', $request->input('is_remove'));
        }

        $today = $request->filled('today') ? $request->input('today') : 0;
        if ($today != 0) {
            $query->whereDate('appointment_time', '>=', Carbon::today());
        }
        if ($service_type) {
            if (is_array($service_type)) {
                $query->whereIn('service_type', $service_type);
            } else {
                $query->where('service_type', $service_type);
            }
        }

        if ($booking_status) {
            if (is_array($booking_status)) {
                $query->whereIn('booking_status', $booking_status);
            } else {
                $query->where('booking_status', $booking_status);
            }
        }

        $bookings = $query->orderBy($scol, $sdir)
            ->paginate($per_page)
            ->appends($request->except('page'));

        return $this->res_paginate('get booking', BookingCardResource::collection($bookings), $bookings);
    }
    public function find($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized: Authentication required.'
            ], 403);
        }

        $query = Booking::with(['user', 'doctor', 'subService.services'])->where('id', $id);
        switch ($user->role_id) {
            case 1: // Admin - Can access any booking
                break;

            case 2: // Doctor - Can only access their own bookings
                $query->where('doctor_id', $user->id);
                break;

            case 3: // Patient - Can only access their own bookings
                $query->where('user_id', $user->id);
                break;

            default:
                return response()->json([
                    'result' => false,
                    'error' => 'Unauthorized: Invalid role'
                ], 403);
        }

        $booking = $query->first();

        if (!$booking) {
            return response()->json([
                'result' => false,
                'error' => 'Booking not found or access denied.'
            ], 404);
        }

        if ($user->role_id !== 2) {
            // return $this->res_success('Get Successfully', $booking);
            return $this->res_success('Get Successfully', new BookingFullResource($booking));
        } else {
            $relatedBookings = Booking::where('user_id', $booking->user_id)
                ->where(function ($q) use ($booking) {
                    $q->where('name', $booking->name)
                        ->orWhere('local_name', $booking->local_name);
                })
                ->get();
            return response()->json([
                'result' => true,
                'message' => 'Get successful',
                'data' => [
                    'booking' => new BookingCardResource($booking),
                    'related_bookings' => RelateBookingResource::collection($relatedBookings),
                ]
            ]);
        }
    }
    public function confirmBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();

        // Notify the user who made the booking
        $user = $booking->user;
        $user->notify(new BookingConfirmedNotification($booking));

        return response()->json(['message' => 'Booking confirmed and notification sent.']);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $user = Auth::user();

        // Check if the user is authorized to update this booking
        if ($booking->user_id !== $user->id && $booking->doctor_id !== $user->id && $user->role_id !== 1) {
            return response()->json([
                'results' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        // Validate the booking status to ensure it is '1' (approved)
        $request->validate([
            'booking_status' => ['required', 'in:1'],
        ]);

        try {
            $data = $request->only(['booking_status']);

            // Check if the booking status is '1' (approved) and update it
            if ($request->has('booking_status') && $request->booking_status == 1) {
                $booking->update($data);

                // Notify the Admin after the booking status is updated
                $adminUsers = User::where('role_id', 1)->get();
                foreach ($adminUsers as $admin) {
                    Notification::create([
                        'user_id' => $admin->id,
                        'booking_id' => $booking->id,
                        'title' => 'New Booking Confirmation',
                        'message' => 'A booking has been confirmed by ' . $user->name,
                    ]);
                }

                return response()->json([
                    'result' => true,
                    'message' => 'Booking status updated and admin notified successfully',
                    'data' => $booking
                ]);
            }

            // If the status is not '1', return an error
            return response()->json([
                'results' => false,
                'error' => 'Booking status must be updated to approved (1)'
            ], 422);
        } catch (\Exception $e) {
            // Catch any exception and return an error response
            return response()->json([
                'result' => false,
                'error' => 'Booking update failed: ' . $e->getMessage()
            ], 500);
        }
    }


    public function checkAvailability(Request $request, $id)
    {
        $user = Auth::user();

        // Check if the user has the required role (role_id = 3)
        if ($user->role_id !== 3) {
            return response()->json([
                'results' => false,
                'error' => 'Unauthorized: Only users with role_id 3 can perform this action.'
            ], 403);
        }

        //
        $request->merge(['doctor_id' => $id]);
        // Validate the incoming request data
        $request->validate([
            'doctor_id' => ['required', 'integer', 'min:2', 'exists:doctor_profiles,user_id'], // Adjust based on your schema
            'appointment_time' => ['required', 'date', 'after:now'],
        ]);

        try {
            // Extract the date from appointment_time
            $date = \Carbon\Carbon::parse($request->appointment_time)->startOfDay();

            // Get all booked time slots for the doctor on the given date
            $bookedSlots = Booking::where('doctor_id', $request->doctor_id)
                ->whereDate('appointment_time', $date)
                ->pluck('appointment_time')
                ->map(fn($time) => \Carbon\Carbon::parse($time)->format('H:i'));

            // Define all possible time slots
            $allSlots = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];

            // Calculate available slots
            $availableSlots = array_diff($allSlots, $bookedSlots->toArray());

            return response()->json([
                'results' => true,
                'message' => 'Available time slots retrieved successfully',
                'date' => $date->toDateString(),
                'available_slots' => array_values($availableSlots) // Reset array keys
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'results' => false,
                'error' => 'Failed to retrieve available slots: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $user = Auth::user();

        if ($booking->user_id !== $user->id && $booking->doctor_id !== $user->id) {
            return response()->json([
                'results' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        try {
            if ($booking->file && Storage::disk('public')->exists($booking->file)) {
                Storage::disk('public')->delete($booking->file);
            }

            $booking->delete();

            return response()->json([
                'results' => true,
                'message' => 'Booking cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'results' => false,
                'error' => 'Booking deletion failed: ' . $e->getMessage()
            ], 500);
        }
    }
    public function completeBooking($bookingId)
    {
        $user = Auth::user();

        if ($user->role_id === 3) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized: You are not allowed to update the booking status'
            ], 403);
        }

        $booking = Booking::find($bookingId);

        if (!$booking) {
            return response()->json([
                'result' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        if ($booking->is_complete) {
            return response()->json([
                'result' => false,
                'message' => 'Booking is already completed'
            ], 400);
        }
        $booking->is_complete = true;
        $booking->save();

        return response()->json([
            'result' => true,
            'message' => 'Booking marked as completed successfully',
            'data' => $booking
        ]);
    }
    public function updateBookingStatus(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role_id !== 1) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized: You are not allowed to update the booking status'
            ], 403);
        }

        $request->validate([
            'booking_status' => ['required', 'integer', 'min:0', 'max:3'],
        ]);

        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json([
                'result' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        if ($request->booking_status == 1) {
            Notification::create([
                'user_id' => $booking->user_id,
                'booking_id' => $booking->id,
                'title' => 'សំណើណាត់ជួបរបស់អ្នកទទួលបានជោគជ័យ',
                'message' => 'សូមកុំភ្លេចមកថ្ងៃណាត់ជួប',
            ]);
        }
        if ($request->booking_status == 2) {
            Notification::create([
                'user_id' => $booking->user_id,
                'booking_id' => $booking->id,
                'is_approve' => 1,
                'title' => 'ការណាត់ជួបរបស់អ្នកត្រូវបានបដិសេធ',
                'message' => 'សូមអភ័យទោស វេជ្ជបណ្ឌិតមិនមាននៅថ្ងៃដែលអ្នកបានជ្រើសទេ។ សូមជ្រើសកាលបរិច្ឆេទថ្មីមួយ',
            ]);
        }

        $booking->booking_status = $request->booking_status;
        $booking->save();

        return response()->json([
            'result' => true,
            'message' => 'Booking status updated successfully',
            'booking' => $booking
        ], 200);
    }

    public function cancelBooking(Request $request, $id)
    {
        $user = Auth::user();

        // Check if the user is the one who created the booking
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json([
                'result' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        // Check if the user role is 3 (customer/user) and if the user is the one who made the booking
        if ($user->role_id !== 3) {
            return response()->json([
                'result' => false,
                'message' => 'Only users can cancel their own bookings'
            ], 403);
        }

        if ($booking->user_id !== $user->id) {
            return response()->json([
                'result' => false,
                'message' => 'You can only cancel your own bookings'
            ], 403);
        }

        $booking->booking_status = 3;
        $booking->save();

        return response()->json([
            'result' => true,
            'message' => 'Booking cancelled successfully',
            'booking' => $booking
        ], 200);
    }
    public function countTypeService(Request $req)
    {
        try {
            $bookings = new Booking();
            $user = Auth::user();

            $counts = [
                'meetingdoctor' => $bookings->where('service_type', 0)
                    ->where('user_id', $user->id)
                    ->count(),
                'checkup' => $bookings->where('service_type', 1)
                    ->where('user_id', $user->id)
                    ->count(),
                'vaccine' => $bookings->where('service_type', 2)
                    ->where('user_id', $user->id)
                    ->count(),
            ];

            return response()->json([
                'result' => true,
                'message' => 'Counting Booking Type Service successfully',
                'data' => $counts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function countTypeBooking(Request $req)
    {
        try {
            $user = $req->user();

            $counts = [
                [
                    'service_type' => 'meetingdoctor',
                    'pending' => Booking::where('service_type', 0)
                        ->where('booking_status', 0)
                        ->where('user_id', $user->id)
                        ->count(),
                    'confirmed' => Booking::where('service_type', 0)
                        ->where('booking_status', 1)
                        ->where('user_id', $user->id)
                        ->count(),
                    'completed' => Booking::where('service_type', 0)
                        ->where('booking_status', 2)
                        ->where('user_id', $user->id)
                        ->count(),
                    'total' => Booking::where('service_type', 0)
                        ->where('user_id', $user->id)
                        ->count(),
                ],
                [
                    'service_type' => 'checkup',
                    'pending' => Booking::where('service_type', 1)
                        ->where('booking_status', 0)
                        ->where('user_id', $user->id)
                        ->count(),
                    'confirmed' => Booking::where('service_type', 1)
                        ->where('booking_status', 1)
                        ->where('user_id', $user->id)
                        ->count(),
                    'completed' => Booking::where('service_type', 1)
                        ->where('booking_status', 2)
                        ->where('user_id', $user->id)
                        ->count(),
                    'total' => Booking::where('service_type', 1)
                        ->where('user_id', $user->id)
                        ->count(),
                ],
                [
                    'service_type' => 'vaccine',
                    'pending' => Booking::where('service_type', 2)
                        ->where('booking_status', 0)
                        ->where('user_id', $user->id)
                        ->count(),
                    'confirmed' => Booking::where('service_type', 2)
                        ->where('booking_status', 1)
                        ->where('user_id', $user->id)
                        ->count(),
                    'completed' => Booking::where('service_type', 2)
                        ->where('booking_status', 2)
                        ->where('user_id', $user->id)
                        ->count(),
                    'total' => Booking::where('service_type', 2)
                        ->where('user_id', $user->id)
                        ->count(),
                ],
            ];

            return response()->json([
                'result' => true,
                'message' => 'Booking count retrieved successfully',
                'data' => $counts,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function countTotalBookingToday(Request $req)
    {
        try {
            $user = $req->user();

            // SELECT * FROM bookings WHERE doctor_id = 2 AND appointment_time = '2025-03-25 10:00:00';
            $counts = [
                [
                    'pending' => Booking::where('appointment_time', now())
                        ->where('doctor_id', $user->id)
                        ->count(),
                ],
            ];

            return response()->json([
                'result' => true,
                'message' => 'Booking count retrieved successfully For Doctor Meeting Today',
                'data' => $counts,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function countTotalInformation(Request $req)
    {
        try {
            $user = $req->user();
            // $today = now()->toDateString(); // Get today's date
            $today = Carbon::today(); // Get today's date
            $counts = [
                'total_appointment' => Booking::whereDate('appointment_time', $today)
                    ->where('doctor_id', $user->id)
                    ->count(),

                'total_patient' => Booking::where('doctor_id', $user->id)
                    ->whereDate('is_complete', 1)
                    ->distinct('user_id')
                    ->count(),

                'total_article' => Article::where('doctor_id', $user->id)
                    ->where('is_published', 1)
                    ->count(),
                'total_published_today' => Article::where('doctor_id', $user->id)
                    ->whereDate('published_at', $today)
                    ->count(),
                'total_reader' => Article::where('doctor_id', $user->id)
                    ->sum('view'),

                'total_views' => Article::whereDate('published_at', $today)
                    ->where('is_published', true)
                    ->where('doctor_id', $user->id)
                    ->sum('view'),

                'total_all_appointment' => Booking::
                    where('doctor_id', $user->id)
                    ->count(),

                'total_complete' => Booking::where('doctor_id', $user->id)
                    ->where('is_complete', 1)
                    ->count(),

                'total_uncomplete' => Booking::where('doctor_id', $user->id)
                    ->where('booking_status', 4)
                    ->count(),
            ];

            return response()->json([
                'result' => true,
                'message' => 'Total Information retrieved successfully',
                'data' => $counts,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function countTotalInformationPatient(Request $req)
    {
        try {
            $user = $req->user();

            $today = now()->toDateString(); // Get today's date in 'YYYY-MM-DD' format

            $counts = [
                'pending' => Booking::whereDate('appointment_time', $today)
                    ->where('doctor_id', $user->id)
                    ->count(),
            ];
            return response()->json([
                'result' => true,
                'message' => 'Booking count retrieved successfully for today\'s doctor meetings',
                'data' => $counts,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function countTotalInformationArticle(Request $req)
    {
        try {
            $user = $req->user();

            $today = now()->toDateString(); // Today's date

            $counts = [
                'total_appointment' => Booking::whereDate('appointment_time', $today)
                    ->where('booking_status', 0) // Assuming 0 means pending
                    ->where('doctor_id', $user->id)
                    ->count(),

                'total_patient' => Booking::where('doctor_id', $user->id)
                    ->whereDate('created_at', $today)
                    ->distinct()
                    ->count('user_id'), // Ensures unique patient count
            ];

            return response()->json([
                'result' => true,
                'message' => 'Total information retrieved successfully',
                'data' => $counts,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
    public function doctorChartData(Request $req)
    {
        try {
            $user = Auth::user();
            if ($user->role_id !== 2) {
                return response()->json([
                    'result' => false,
                    'message' => 'Only for Doctor'
                ], 403);
            }
            $now = Carbon::now();
            $start = $now->copy()->subMonths(8)->startOfMonth(); // 5 months ago
            $end = $now->copy()->endOfMonth();
            $rawData = Booking::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as count')
            )
                ->where('doctor_id', $user->id)
                ->where('is_complete', 1)
                ->whereBetween('created_at', [$start, $end])
                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                ->orderBy('month')
                ->pluck('count', 'month');

            $data = [];
            $labels = [];
            for ($i = 7; $i >= 0; $i--) {
                $date = $now->copy()->subMonths($i);
                $monthKey = $date->format('Y-m');
                $monthLabel = $date->format('F');

                $labels[] = $monthLabel;
                $data[] = $rawData->get($monthKey, 0);
            }

            $males = Booking::where('doctor_id', $user->id)->where('is_complete', 1)->where('gender', 1)->count();
            $females = Booking::where('doctor_id', $user->id)->where('is_complete', 1)->where('gender', 2)->count();

            $counts = [
                'chart_data' => $data,
                'month_data' => $labels,
                'male_patient' => $males,
                'female_patient' => $females,
            ];

            return response()->json([
                'result' => true,
                'message' => 'Total information retrieved successfully',
                'data' => $counts,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
    public function countTotalInformationWebsite(Request $req)
    {
        try {
            $user = $req->user();
            $now = Carbon::now();
            $start = $now->copy()->subMonths(5)->startOfMonth(); // 5 months ago
            $end = $now->copy()->endOfMonth();

            $rawData = Booking::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as count')
            )
                ->where('is_complete', 1)
                ->whereBetween('created_at', [$start, $end])
                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                ->orderBy('month')
                ->pluck('count', 'month');

            $data = [];
            $labels = [];
            for ($i = 5; $i >= 0; $i--) {
                $date = $now->copy()->subMonths($i);
                $monthKey = $date->format('Y-m');
                $monthLabel = $date->format('F');

                $labels[] = $monthLabel;
                $data[] = $rawData->get($monthKey, 0);
            }
            $counts = [
                'total_doctor' => User::where('role_id', 2)
                    ->count(),

                'total_service_checkup' => Booking::where('service_type', 1)
                    ->count(),

                'total_service_vaccine' => Booking::where('service_type', 2)
                    ->count(),

                'total_contact' => Contact::count(),
                'chart_data' => $data,
                'month_data' => $labels,
            ];

            return response()->json([
                'result' => true,
                'message' => 'Total information retrieved successfully',
                'data' => $counts,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
    public function removeBooking(Request $request, $id)
    {
        $user = Auth::user();
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json([
                'result' => false,
                'message' => 'Booking not found'
            ], 404);
        }
        if ($user->role_id !== 3) {
            return response()->json([
                'result' => false,
                'message' => 'Only users can cancel their own bookings'
            ], 403);
        }

        if ($booking->user_id !== $user->id) {
            return response()->json([
                'result' => false,
                'message' => 'You can only cancel your own bookings'
            ], 403);
        }

        $booking->is_remove = true;
        $booking->save();

        return response()->json([
            'result' => true,
            'message' => 'Booking cancelled successfully',
            'booking' => $booking
        ], 200);
    }

    public function getCalendar(Request $request)
    {
        $request->validate(['today' => ['nullable', 'boolean']]);

        $today = $request->filled('today') ? $request->input('today') : 0;
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized: Authentication required.'
            ], 403);
        }
        if ($user->role_id !== 2) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized: Only doctor.'
            ], 403);
        }
        $bookings = Booking::query();

        if ($today != 0)
            $bookings = $bookings->whereDate('appointment_time', Carbon::today());
        else
            $bookings = $bookings
                ->where('appointment_time', '>=', Carbon::today());

        $bookings = $bookings->with(['user', 'doctor'])
            ->where('doctor_id', $user->id)
            ->where('booking_status', '!=', 0)
            ->where('service_type', 0)
            ->orderBy('appointment_time', 'asc')
            ->get();
        return $this->res_success('get booking successful', BookingCardResource::collection($bookings));
    }
    public function getBookingCalendar(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized: Authentication required.'
            ], 403);
        }
        if ($user->role_id !== 1) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized: Only admin.'
            ], 403);
        }

        $bookings = Booking::with(['user', 'doctor'])
            ->where('appointment_time', '>=', Carbon::today())
            ->whereIn('booking_status', [1, 4])
            ->orderBy('appointment_time', 'asc')
            ->get();
        return $this->res_success('get booking successful', BookingCardResource::collection($bookings));
    }
    public function doctorBooking(Request $req, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized: Authentication required.'
            ], 403);
        }

        if ($user->role_id !== 1) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized: Only admin.'
            ], 403);
        }

        $req->merge(['id' => $id]);
        $req->validate(['id' => ['required', 'integer', 'min:1', 'exists:users,id']]);

        $bookings = Booking::with(['user', 'doctor.doctorProfile.specialist', 'doctor.doctorProfile.department', 'doctor.doctorProfile.center'])
            ->where('service_type', 0)
            ->where('doctor_id', $id)
            ->where('is_complete', 1)
            ->get();
        $doctors = [];
        $bookingArray = [];

        $doctor = $bookings->isNotEmpty() ? $bookings->first()->doctor : User::with('doctorProfile.specialist', 'doctorProfile.department', 'doctorProfile.center')->find($id);

        if ($doctor) {
            $doctorProfile = $doctor->doctorProfile;
            $doctors = [
                'id' => $doctor->id,
                'fullname' => $doctor->fullname,
                'local_fullname' => $doctor->local_fullname,
                'gender' => $doctor->gender,
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
        }

        $bookingArray = BookingMiniCardResource::collection($bookings);


        $booking_all = Booking::where('doctor_id', $id)->count();
        $booking_success = Booking::where('doctor_id', $id)
            ->where('is_complete', 1)->count();

        return response()->json([
            'result' => true,
            'message' => 'Get successful',
            'data' => [
                'summary' => [
                    'all' => $booking_all,
                    'success' => $booking_success,
                ],
                'doctor' => $doctors,
                'booking' => $bookingArray,
            ],
        ]);
    }

    public function assignDoctor(Request $req)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized: Authentication required.'
            ]);
        }
        if ($user->role_id != 1) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized: Only admin.'
            ], 403);
        }

        $req->validate([
            'id' => ['required', 'integer', 'min:1', 'exists:bookings,id'],
            'doctor_id' => ['required', 'integer', 'min:1', 'exists:users,id'],
        ]);
        $booking = Booking::findOrFail($req->input('id'));
        $booking->update(['doctor_id' => $req->input('doctor_id')]);


        return $this->res_success('update success');

    }
    public function checkDoctor(Request $req)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized: Authentication required.'
            ]);
        }
        if ($user->role_id != 1) {
            return response()->json([
                'result' => false,
                'error' => 'Unauthorized: Only admin.'
            ], 403);
        }
        $req->validate([
            'appointment_time' => ['required', 'date'],
            'search' => ['nullable', 'string', 'max:250'],
        ]);

        $search = $req->filled('search') ? $req->input('search') : null;
        $appointmentDateTime = Carbon::parse($req->input('appointment_time'))->toDateTimeString();

        $doctors = User::with(['doctorProfile.specialist', 'bookings'])
            ->where('users.role_id', 2)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('fullname', 'like', "%{$search}%")
                        ->orWhere('local_fullname', 'like', "%{$search}%");
                })
                    ->orWhereHas('doctorProfile.specialist', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('local_name', 'like', "%{$search}%");
                    });
            })
            ->whereDoesntHave('doctorBookings', function ($query) use ($appointmentDateTime) {
                $query->where('appointment_time', $appointmentDateTime);
            })
            ->get();
        $doctorData = $doctors->map(function ($doctor) {
            return [
                'id' => $doctor->id,
                'fullname' => $doctor->fullname,
                'local_fullname' => $doctor->local_fullname,
                'avatar' => asset(
                    $doctor->avatar && $doctor->avatar !== 'user/no_avatar.jpg'
                    ? 'storage/' . $doctor->avatar
                    : 'storage/user/no_avatar.jpg'
                ),
                'specialist' => $doctor->doctorProfile?->specialist ? [
                    'name' => $doctor->doctorProfile->specialist->name,
                    'local_name' => $doctor->doctorProfile->specialist->local_name,
                ] : null
            ];
        });

        return response()->json([
            'result' => true,
            'message' => 'Get successfully',
            'data' => $doctorData,
        ]);
    }
}
