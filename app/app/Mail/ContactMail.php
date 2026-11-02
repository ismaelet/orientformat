<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $content;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $email,
        public string $name,
        public string $message,
        public string $position,
        public ?array $parameters = null
    ) {
        $this->content = 'Richiesta informazioni dal/dalla '.$this->position.' <strong>'.$this->name.'</strong> ('.$this->email.')';

        $this->content .= ':<br><br>"'.$this->message.'"';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            replyTo: [
                new Address($this->email, $this->name),
            ],
            subject: 'Richiesta informazioni da '.$this->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.default-email',
            with: ['content' => $this->content],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
