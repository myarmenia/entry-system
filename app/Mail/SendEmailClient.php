<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailClient extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $data) {}

    public function build()
    {
        // return $this->to($this->user->email)
        //     ->subject('Ելք չունեցող աշխատակիցների ցանկ')
        //     ->view('emails.listOfWorkersWthoutExit', ['user' => $this->user]);
            return $this->to('armine.khachatryan1982@gmail.com')
            ->subject('Ելք չունեցող աշխատակիցների ցանկ')
            ->view('emails.listOfWorkersWthoutExit', ['user' => $this->data]);
    }
    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Send Email Client',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
