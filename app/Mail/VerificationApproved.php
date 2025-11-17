<?php

namespace App\Mail;

use App\Models\AkunUbsc;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $account;

    public function __construct(AkunUbsc $account)
    {
        $this->account = $account;
    }

    public function build()
    {
        return $this->subject('Verifikasi Akun Warga UB - Disetujui')
                    ->view('emails.verification-approved');
    }
}