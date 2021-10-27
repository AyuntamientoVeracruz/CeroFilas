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
        $address = __('lblEmailInstitutional');
        $name = __('lblName');
        $subject =  __('lblMsg3');
        
        return $this->view('emails.verifyUser')
                    ->from($address, $name)
                    ->subject($subject);
    }
}
