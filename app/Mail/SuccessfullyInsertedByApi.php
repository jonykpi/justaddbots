<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SuccessfullyInsertedByApi extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $upload_text,$content,$summery,$prompt;
    public function __construct($upload_text,$content,$summery,$prompt)
    {
        $this->upload_text = $upload_text;
        $this->content = $content;
        $this->summery = $summery;
        $this->prompt = $prompt;

        Log::info('mail test');
        Log::info($this->upload_text);
        Log::info($this->content);
        Log::info($this->summery);

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        return new Envelope(
            subject: 'You’ve successfully '.$this->upload_text.' '.$this->content->file_title.' to folder '.$this->content->folder->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.successfullyInsertedByApi',
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
