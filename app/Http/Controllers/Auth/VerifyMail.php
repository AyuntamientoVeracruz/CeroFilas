<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;
     public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
    {
          $address = 'citas@veracruzmunicipio.gob.mx';
          $name = 'Ayuntamiento de Veracruz';
          $subject = 'Activación de la cuenta';
        return $this->view('emails.verifyUser')
                    ->from($address, $name)
                    ->subject($subject);
    }
}
