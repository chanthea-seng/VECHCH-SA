<?php

namespace App\Http\Controllers\MedicalRecord;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BookingController;
use App\Http\Resources\MedicalRecordResource;
use App\Models\Booking;
use App\Models\Examination;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Psy\Command\WhereamiCommand;


class MedicalRecordController extends Controller
{
    protected $bookingController;

    public function __construct(BookingController $bookingController)
    {
        $this->bookingController = $bookingController;
    }
    private function authorizeRequest($user, $record = null)
    {
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }
        return null;
    }

    public function index()
    {
        $user = Auth::user();
        if ($unauthenticated = $this->authorizeRequest($user))
            return $unauthenticated;

        if ($user->role_id === 1 || $user->role_id === 2) {
            $records = MedicalRecord::with(['booking', 'doctor', 'examinations', 'prescriptions'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $records = MedicalRecord::whereHas('booking', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->with(['booking', 'doctor', 'examinations', 'prescriptions'])
                ->orderBy('created_at', 'desc')
                ->get();
        }


        return response()->json([
            'result' => true,
            'message' => 'Fetched Medical Records',
            'data' => MedicalRecordResource::collection($records)
        ]);
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($unauthenticated = $this->authorizeRequest($user))
            return $unauthenticated;

        if ($user->role_id !== 2) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized: Only doctors can create medical records'
            ], 403);
        }

        $validated = $request->validate([
            'booking_id' => ['required', 'exists:bookings,id', 'unique:medical_records,booking_id'],
            'message' => ['nullable', 'string', 'max:65530'],
            'notes' => ['required', 'array'],
            'notes.*.type' => ['required', 'string', 'in:examination,prescription'],
            'notes.*.name' => ['required_if:notes.*.type,examination', 'string'],
            'notes.*.result' => ['required_if:notes.*.type,examination', 'string'],
            'notes.*.status' => ['required_if:notes.*.type,examination', 'string'],
            'notes.*.medication' => ['required_if:notes.*.type,prescription', 'string'],
            'notes.*.dosage' => ['required_if:notes.*.type,prescription', 'string'],
            'notes.*.frequency' => ['required_if:notes.*.type,prescription', 'string'],
            'notes.*.duration' => ['required_if:notes.*.type,prescription', 'string'],
        ]);

        $record = MedicalRecord::create([
            'booking_id' => $validated['booking_id'],
            'doctor_id' => $user->id,
            'message' => $validated['message']
        ]);

        foreach ($validated['notes'] as $note) {
            if ($note['type'] === 'examination') {
                Examination::create([
                    'medical_record_id' => $record->id,
                    'name' => $note['name'],
                    'result' => $note['result'],
                    'status' => $note['status'],
                ]);
            } elseif ($note['type'] === 'prescription') {
                Prescription::create([
                    'medical_record_id' => $record->id,
                    'name' => $note['medication'],
                    'dosage' => $note['dosage'],
                    'frequency' => $note['frequency'],
                    'duration' => $note['duration'],
                ]);
                $notification = new Notification();
                $notification->user_id = $record->booking->user_id;
                $notification->booking_id = $record->booking_id;
                $notification->title = 'New Prescription';
                $notification->message = 'You have a new prescription from ' . $user->fullname;
                $notification->save();
            }
        }
        $this->bookingController->completeBooking($validated['booking_id']);

        return response()->json([
            'result' => true,
            'message' => 'Medical record created successfully',
            'data' => new MedicalRecordResource($record->load(['booking', 'doctor', 'examinations', 'prescriptions']))
        ], 201);
    }

    public function find($id)
    {
        $user = Auth::user();
        if ($unauthenticated = $this->authorizeRequest($user)) {
            return $unauthenticated;
        }

        $record = MedicalRecord::with(['booking', 'doctor', 'examinations', 'prescriptions'])->findOrFail($id);

        $isAuthorized = $user->role_id === 1 ||
            ($user->role_id === 2 && $record->doctor_id === $user->id) ||
            ($record->booking && $record->booking->user_id === $user->id);

        if (!$isAuthorized) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'result' => true,
            'message' => 'Medical record found',
            'data' => new MedicalRecordResource($record)
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($unauthenticated = $this->authorizeRequest($user)) {
            return $unauthenticated;
        }

        $record = MedicalRecord::findOrFail($id);

        if (
            $user->role_id !== 1 &&
            ($user->role_id !== 2 || $record->doctor_id !== $user->id)
        ) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'examinations' => ['nullable', 'array'],
            'examinations.*.id' => ['nullable', 'exists:examinations,id'],
            'examinations.*.name' => ['required', 'string'],
            'examinations.*.result' => ['required', 'string'],
            'examinations.*.status' => ['required', 'string'],
            'prescriptions' => ['nullable', 'array'],
            'prescriptions.*.id' => ['nullable', 'exists:prescriptions,id'],
            'prescriptions.*.medication' => ['required', 'string'],
            'prescriptions.*.dosage' => ['required', 'string'],
            'prescriptions.*.frequency' => ['required', 'string'],
            'prescriptions.*.duration' => ['required', 'string'],
        ]);

        // Update Examinations
        if (isset($validated['examinations'])) {
            $existingExaminationIds = $record->examinations->pluck('id')->toArray();
            $updatedExaminationIds = array_filter(array_column($validated['examinations'], 'id'));

            $examinationsToDelete = array_diff($existingExaminationIds, $updatedExaminationIds);
            Examination::whereIn('id', $examinationsToDelete)->delete();

            foreach ($validated['examinations'] as $examData) {
                if (isset($examData['id'])) {
                    Examination::where('id', $examData['id'])->update([
                        'name' => $examData['name'],
                        'result' => $examData['result'],
                        'status' => $examData['status'],
                    ]);
                } else {
                    Examination::create([
                        'medical_record_id' => $record->id,
                        'name' => $examData['name'],
                        'result' => $examData['result'],
                        'status' => $examData['status'],
                    ]);
                }
            }
        }

        // Update Prescriptions
        if (isset($validated['prescriptions'])) {
            $existingPrescriptionIds = $record->prescriptions->pluck('id')->toArray();
            $updatedPrescriptionIds = array_filter(array_column($validated['prescriptions'], 'id'));

            $prescriptionsToDelete = array_diff($existingPrescriptionIds, $updatedPrescriptionIds);
            Prescription::whereIn('id', $prescriptionsToDelete)->delete();

            foreach ($validated['prescriptions'] as $presData) {
                if (isset($presData['id'])) {
                    Prescription::where('id', $presData['id'])->update([
                        'name' => $presData['medication'],
                        'dosage' => $presData['dosage'],
                        'frequency' => $presData['frequency'],
                        'duration' => $presData['duration'],
                    ]);
                } else {
                    Prescription::create([
                        'medical_record_id' => $record->id,
                        'name' => $presData['medication'],
                        'dosage' => $presData['dosage'],
                        'frequency' => $presData['frequency'],
                        'duration' => $presData['duration'],
                    ]);
                }
            }
        }
        // $this->bookingController->completeBooking($validated['booking_id']);

        return response()->json([
            'result' => true,
            'message' => 'Medical record updated successfully',
            'data' => new MedicalRecordResource($record->load(['booking', 'doctor', 'examinations', 'prescriptions']))
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if ($unauthenticated = $this->authorizeRequest($user))
            return $unauthenticated;

        if ($user->role_id !== 1) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized: Only admins can delete records'
            ], 403);
        }

        $record = MedicalRecord::with(['examinations', 'prescriptions'])->findOrFail($id);
        $record->delete();

        return response()->json([
            'result' => true,
            'message' => 'Medical record deleted successfully',
            'data' => ['record_id' => $id]
        ]);
    }

    public function getMedicalRecord(Request $request)
    {
        $user = Auth::user();
        if ($unauthenticated = $this->authorizeRequest($user))
            return $unauthenticated;

        $search = null;
        if ($request->filled('search'))
            $search = $request->input('search');

        $query = MedicalRecord::with(['doctor', 'booking'])
            ->whereHas('prescriptions');

        if ($user->role_id === 3) {
            $query = $query->whereHas('booking', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }
        ;

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('doctor', function ($subQuery) use ($search) {
                    $subQuery->where('fullname', 'like', "%$search%")
                        ->orWhere('local_fullname', 'like', "%$search%");
                })
                    ->orWhereHas('booking.user', function ($subQuery) use ($search) {
                        $subQuery->where('fullname', 'like', "%$search%")
                            ->orWhere('local_fullname', 'like', "%$search%");
                    });
            });
        }
        $prescriptions = $query->orderBy('created_at', 'desc')->get()->map(function ($record) {
            return [
                'id' => $record->id,
                'service_type' => $record->booking->service_type ?? null,
                'appointment' => isset($record->booking->appointment_time)
                    ? Carbon::parse($record->booking->appointment_time)->format('d/m/Y H:i')
                    : null,
                'created_at' => $record->created_at->format('d/m/Y h:i A'),
                'doctor_name' => $record->doctor->fullname ?? 'Unknown',
                'patient_name' => $record->booking->user->fullname ?? 'Unknown',
                'patient_local_name' => $record->booking->user->local_fullname ?? 'Unknown',
                'description' => $record->message,
            ];
        });

        return response()->json([
            'result' => true,
            'message' => 'Fetched Prescriptions',
            'data' => $prescriptions
        ]);
    }
    public function getUserMedicalRecord(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        if ($user->role_id != 2) {
            return response()->json([
                'result' => false,
                'message' => 'Permission denied: Only Docor is allow.'
            ], 403);
        }

        $request->merge(['id' => $id]);
        $request->validate(['id' => ['required', 'integer', 'min:1', 'exists:users,id']]);
        $query = MedicalRecord::with(['doctor', 'booking'])
            ->whereHas('booking', function ($q) use ($id) {
                $q->where('user_id', $id);
            });
        $prescriptions = $query->orderBy('created_at', 'desc')->get()->map(function ($record) {
            return [
                'id' => $record->id,
                'service_type' => $record->booking->service_type ?? null,
                'appointment' => isset($record->booking->appointment_time)
                    ? Carbon::parse($record->booking->appointment_time)->format('d/m/Y H:i')
                    : null,
                'created_at' => $record->created_at->format('d/m/Y h:i A'),
                'doctor_name' => $record->doctor->fullname ?? 'Unknown',
                'patient_name' => $record->booking->user->fullname ?? 'Unknown',
                'patient_local_name' => $record->booking->user->local_fullname ?? 'Unknown',
                'description' => $record->message,
            ];
        });
        return $this->res_success('Get medical-record success', $prescriptions);
    }
    public function downloadInvoice($id)
    {
        $user = Auth::user();
        if ($unauthenticated = $this->authorizeRequest($user)) {
            return $unauthenticated;
        }
        try {
            $record = Booking::with(['user', 'subService', 'subService.services'])
                ->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Invalid record: missing booking information'
            ], 404);
        } catch (\Exception $e) {
            return response()->json(['result' => false, 'message' => 'Database error'], 500);
        }

        if (!$record) {
            return response()->json([
                'result' => false,
                'message' => 'Invalid record: missing booking information'
            ], 404);
        }

        // Prepare data for the PDF
        $data = [
            'record_no' => sprintf('%03d %03d %03d', $record->id, $record->user_id, $record->sub_service_id ?? 0),
            'date' => \Carbon\Carbon::parse($record->created_at)->format('d-m-Y'),
            'local_name' => $record->local_name ?? null,
            'english_name' => $record->name ?? null,
            'gender' => $record->gender == 1 ? 'ប្រុស' : 'ស្រី',
            'dob' => $record->dob,
            'phone' => $record->phone_number,
            'email' => $record->email,
            'payment_method' => $record->payment_method ?? 'Cash', // Fixed from $booking to $record
            'service_type' => $record->service_type == 2
                ? 'ជួបវេជ្ជបណ្ឌិត'
                : ($record->service_type == 1
                    ? 'ពិនិត្យសុខភាព'
                    : 'ចាក់វ៉ាក់សាំង'),
            'services' => [],
            'instruction' => htmlspecialchars_decode(
                $record->subService->services->instruction ?? null
                ,
                ENT_QUOTES | ENT_HTML5
            ),
            'sub_total' => $record->subService->price ?? "N/A",
            'deposit' => $record->subService->price ?? "N/A",
            'total' => $record->subService->price ?? "N/A",
        ];

        $data['total'] = $data['sub_total'];
        $serviceNames = array_map('trim', explode(',', $record->subService->description ?? ''));

        $serviceCounter = 1;
        foreach ($serviceNames as $name) {
            if (!empty($name)) {
                $data['services'][] = [
                    'no' => $serviceCounter++,
                    'name' => $name,
                ];
            }
        }
        $filename = 'invoice-' . $id . '-' . now()->format('YmdHis') . '.pdf';
        $filePath = 'invoices/' . $filename;

        try {
            $pdf = LaravelMpdf::loadView('pdf.receipt', $data);
            $pdfContent = $pdf->output();

            if (empty($pdfContent)) {
                throw new \Exception('PDF generation produced no content');
            }

            Storage::put($filePath, $pdfContent);

            $url = Storage::temporaryUrl($filePath, now()->addHour());

            return response()->json([
                'result' => true,
                'message' => 'PDF generated successfully',
                'download_url' => $url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }
    public function downloadMedicalRecord($id)
    {
        $user = Auth::user();

        if ($unauthenticated = $this->authorizeRequest($user)) {
            return $unauthenticated;
        }

        $record = MedicalRecord::with(['booking', 'booking.user', 'doctor', 'examinations', 'prescriptions'])
            ->findOrFail($id);

        $isAuthorized = $user->role_id === 1 ||
            ($user->role_id === 2 && $record->doctor_id === $user->id) ||
            ($record->booking && $record->booking->user_id === $user->id);

        if (!$isAuthorized) {
            return response()->json([
                'result' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $booking = $record->booking;

        if (!$booking) {
            return response()->json([
                'result' => false,
                'message' => 'Invalid record: missing booking information'
            ], 404);
        }


        $data = [
            'record_no' => sprintf('%03d %03d %03d', $record->id, $record->booking_id, $record->doctor_id),
            'date' => \Carbon\Carbon::parse($record->created_at)->format('d-m-Y'),
            'local_name' => $record->booking->local_name ?? $record->booking->name,
            'english_name' => $record->booking->name,
            'gender' => $record->booking->gender == 1 ? 'ប្រុស' : 'ស្រី',
            'dob' => $record->booking->dob,
            'phone' => $record->booking->phone_number,
            'email' => $record->booking->email,
            'doctors_note' => $record->message ?? 'No doctor\'s note available.',
        ];

        $serviceCounter = 1;

        $serviceCounter = 1;
        $data['examinations'] = [];
        foreach ($record->examinations as $exam) {
            $data['examinations'][] = [
                'no' => $serviceCounter++,
                'name' => $exam->name,
                'result' => $exam->result,
                'status' => $exam->status, // Normalize status to lowercase
            ];
        }

        $data['prescriptions'] = [];
        foreach ($record->prescriptions as $pres) {
            $data['prescriptions'][] = [
                'no' => $serviceCounter++,
                'name' => $pres->name,
                'dosage' => $pres->dosage,
                'frequency' => $pres->frequency,
                'duration' => $pres->duration,
            ];
        }

        $filename = 'medical-record-' . $id . '-' . now()->format('YmdHis') . '.pdf';
        $filePath = 'receipts/' . $filename;

        try {
            $pdf = LaravelMpdf::loadView('pdf.medicalRecord', $data);
            $pdfContent = $pdf->output();

            if (empty($pdfContent)) {
                throw new \Exception('PDF generation produced no content');
            }

            Storage::put($filePath, $pdfContent);

            $url = Storage::temporaryUrl($filePath, now()->addHour());

            return response()->json([
                'result' => true,
                'message' => 'PDF generated',
                'download_url' => $url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }
}
