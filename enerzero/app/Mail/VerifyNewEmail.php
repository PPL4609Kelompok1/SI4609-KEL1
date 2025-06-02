<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User; // Penting: Import model User Anda

class VerifyNewEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;
    public $verificationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
        // Bangun URL verifikasi
        $this->verificationUrl = route('verify.email.change', ['token' => $token]);
        // Anda bisa tambahkan email pengguna ke URL jika perlu untuk prefill form,
        // contoh: $this->verificationUrl = route('verify.email.change', ['token' => $token, 'email' => $user->pending_email]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Perubahan Alamat Email Anda',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // Menggunakan view Blade kustom untuk email
            view: 'emails.verify_new_email',
            with: [
                'userName' => $this->user->username, // Atau $this->user->name jika ada
                'verificationLink' => $this->verificationUrl,
                'token' => $this->token,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}