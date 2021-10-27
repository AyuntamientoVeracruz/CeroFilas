<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestValoracion extends Mailable
{
    use Queueable, SerializesModels;
     public $turno;
	 public $foliovaloracion;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($turno,$foliovaloracion)
    {
        $this->turno = $turno;
        $this->foliovaloracion = $foliovaloracion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
    {
        $msg = 


          $address =__('lblEmailInstitutional');
          $name = __('lblName');
          $subject = __('lblMsg1');
		  return $this->view('emails.requestvaloracionMail')
						->from($address, $name)
						->subject($subject);
    }
}
