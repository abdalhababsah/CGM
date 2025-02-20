<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $invoicePath;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param mixed $invoicePath
     */
    public function __construct(Order $order, mixed $invoicePath)
    {
        $this->order = $order;
        $this->invoicePath = $invoicePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Invoice for Order #' . $this->order->id)
                    ->view('emails.invoice');
                    // ->attach($this->invoicePath, [
                    //     'as' => 'invoice-' . $this->order->id . '.pdf',
                    //     'mime' => 'application/pdf',
                    // ]);
    }
}
