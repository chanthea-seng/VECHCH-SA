<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessBookingCreation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Number of retry attempts
    public $backoff = 60; // Seconds to wait between retries

    protected $bookingData;

    public function __construct(array $bookingData)
    {
        $this->bookingData = $bookingData;
    }

    public function handle()
    {
        DB::beginTransaction();

        try {
            $booking = new Booking();
            $booking->fill($this->bookingData);
            $booking->save();

            DB::commit();

            // Optional: Add event dispatching
            // event(new BookingCreated($booking));

        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($this->bookingData['file']) && Storage::disk('public')->exists($this->bookingData['file'])) {
                Storage::disk('public')->delete($this->bookingData['file']);
            }

            Log::error('Booking creation failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
