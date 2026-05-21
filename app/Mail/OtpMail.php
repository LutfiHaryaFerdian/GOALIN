<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $code,
        public string $type,
        public int    $expiryMinutes
    ) {}

    public function envelope(): Envelope
    {
        $subject = match ($this->type) {
            'registration'    => '[GOALIN] Kode Verifikasi Registrasi',
            'password_change' => '[GOALIN] Kode Verifikasi Ganti Password',
            default           => '[GOALIN] Kode OTP',
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.auth.otp',
            with: [
                'code'          => $this->code,
                'type'          => $this->type,
                'expiryMinutes' => $this->expiryMinutes,
            ]
        );
    }
}
