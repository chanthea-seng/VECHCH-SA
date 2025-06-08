<?php
namespace App\Jobs;

use App\Models\ServiceImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessServiceImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $imagePaths;
    protected $serviceId;

    public function __construct(array $imagePaths, int $serviceId)
    {
        $this->imagePaths = $imagePaths;
        $this->serviceId = $serviceId;
    }

    public function handle(): void
    {
        foreach ($this->imagePaths as $tempPath) {
            // Move from temp to final service directory
            $newPath = str_replace('temp/', 'service/', $tempPath);
            Storage::disk('public')->move($tempPath, $newPath);

            ServiceImage::create([
                'service_id' => $this->serviceId,
                'image_path' => $newPath,
            ]);
        }
    }

    // Optional: Clean up temp files if the job fails
    public function failed(\Throwable $exception): void
    {
        foreach ($this->imagePaths as $tempPath) {
            Storage::disk('public')->delete($tempPath);
        }
        Log::error("Image processing failed for service {$this->serviceId}: {$exception->getMessage()}");
    }
}
