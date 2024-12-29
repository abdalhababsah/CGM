<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Public property to hold the contact data

    /**
     * Create a new message instance.
     *
     * @param array $data Contact form data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Use the HTML view for the email
        return $this->subject('New Contact Us Message')
                    ->view('emails.contact_us')
                    ->with('data', $this->data);
    }
}