<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class orderReady extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = "Estado pedido Ramen Dashi";
    public $cliente;
    public $date;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($date)
    {   
        $this->cliente = $date;
        
    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.orderReady');
    }
}
