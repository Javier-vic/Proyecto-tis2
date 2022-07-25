<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class welcomeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = "Descuentos ramen dashi";
    public $cliente;
    public $date;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cliente,$date)
    {
        $this->cliente = $cliente; 
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.welcome-mail');
       
    }       
}
