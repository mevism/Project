<?php

namespace Modules\Registrar\emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class KuccpsMails extends Mailable
{
    use Queueable, SerializesModels;

    public $kuccpsApplicant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $kuccpsApplicant)
    {
        $this->kuccpsApplicant = $kuccpsApplicant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Technical University of Mombasa')->view('registrar::mail.kuccpsemail');
    }
}
