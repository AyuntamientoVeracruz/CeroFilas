<?php

namespace App\Mail;

use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SavelevantamientoMail extends Mailable
{
    use Queueable, SerializesModels;
     public $levantamiento;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($levantamiento)
    {
        $this->levantamiento = $levantamiento;                                
    }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
    {      

          $subject = 'Levantamiento registrado con éxito';

          return $this->view('emails.savelevantamientoMail')
						->subject($subject);
    }
}
