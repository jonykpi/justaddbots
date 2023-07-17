<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SuccessfullySendUploadEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $_from,$upload_text,$content,$summery,$prompt,$link,$include,$request,$setings;
    public function __construct($_from,$upload_text,$request,$content,$summery,$prompt,$link,$include,$setings)
    {
        $this->upload_text = $upload_text;
        $this->content = $content;
        $this->summery = $summery;
        $this->prompt = $prompt;
        $this->link = $link;
        $this->include = $include;
        $this->request = $request;
        $this->_from = $_from;
        $this->setings = $setings;


    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

      if ($this->setings->from = 'c' && isset($this->setings->custom_subject) && !empty($this->setings->custom_subject)){
          return new Envelope(
              subject: $this->setings->custom_subject,
          );
      }else{
          return new Envelope(
              subject: 'You’ve successfully '.$this->upload_text.' '.$this->content->file_title.' to folder '.$this->content->folder->name,
          );
      }

    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.successfullyInsertedByEmail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {

        if ($this->include == "m"){
            return [
                Attachment::fromPath($this->request['attachments'][0]['file_path'])
                    ->as($this->request['attachments'][0]['file_name'])
                    ->withMime($this->request['attachments'][0]['content_type']),
            ];
        }else{
            return [];
        }


    }
}
