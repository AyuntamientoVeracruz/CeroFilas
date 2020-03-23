<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetMail extends Mailable
{
    use Queueable, SerializesModels;
     public $user;
	 public $newpass;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$newpass)
    {
        $this->user = $user;
		$this->newpass = $newpass;
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
          $subject = 'Nuevo password de acceso al sistema';
		  return $this->view('emails.resetMail')
						->from($address, $name)
						->subject($subject);
    }
}
