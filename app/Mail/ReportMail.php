<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $clientName,
        public string $projectName,
        public ?string $message = null,
        public ?string $pdfPath = null,
    ) {}

    /**
     * Sujet et expéditeur.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rapport d’avancement - ' . $this->projectName,
        );
    }

    /**
     * Contenu du mail.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.report',
        );
    }

    /**
     * Pièces jointes.
     */
    public function attachments(): array
    {
        if (!$this->pdfPath) {
            return [];
        }

        return [
            Attachment::fromPath($this->pdfPath)
                ->as('rapport-' . str($this->projectName)->slug() . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
