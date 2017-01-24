<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $total;

    public function __construct()
    {
        $total = 30;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = "marvin.holleman@hotmail.nl";
        $name = "Bestuur";
        $subject = "Bevestiging reservering kinderfeestje 2017";
        return $this->view('emails.confirmation')->from($address, $name)->subject($subject);
    }
}
