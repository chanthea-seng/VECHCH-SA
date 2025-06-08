<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MedicalRecordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $record;
    public $pdfContent;

    public function __construct($record, $pdfContent)
    {
        $this->record = $record;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Your Medical Record')
            ->view('emails.medical_record')
            ->attachData($this->pdfContent, 'medical_record.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
