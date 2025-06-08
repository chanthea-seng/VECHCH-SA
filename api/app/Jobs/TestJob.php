<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log; // This import is correct

class TestJob implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        Log::info('Test job is running!'); // Use Log::info without the leading \
    }
}
