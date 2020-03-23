<?php

namespace App\Mail;

use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SavedateMail extends Mailable
{
    use Queueable, SerializesModels;
     public $folio;
     public $nombre;
	 public $tramite;
	 public $oficina;
     public $fechahora;
     public $email;
     public $curp;
     public $recordatorio;
     public $googlemapskey;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($folio, $nombre, $tramite, $oficina, $fechahora, $email, $curp, $recordatorio=false,$googlemapskey=false)
    {
        $this->folio = $folio;
        $this->nombre = $nombre;
		$this->tramite = $tramite;
		$this->oficina = $oficina;
        $this->fechahora = $fechahora;
        $this->email = $email;
        $this->curp = $curp;
        $this->recordatorio = $recordatorio;
        $this->googlemapskey = DB::table('configuraciones')
                        ->where('service_name','google_maps')
                        ->first();   
                        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
    {      

          if($this->recordatorio==true){
            $subject = 'Recordatorio de cita de trámite';
		  }
          else{
            $subject = 'Cita de trámite registrada con éxito';
          }
          return $this->view('emails.savedateMail')
						->subject($subject);
    }
}
