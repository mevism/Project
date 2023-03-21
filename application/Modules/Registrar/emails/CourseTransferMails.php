<?php

namespace Modules\Registrar\emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseTransferMails extends Mailable
{

    use Queueable, SerializesModels;
    public $newStudent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newStudent)
    {
         $this->newStudent =  $newStudent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(' Course Transfer')->view('registrar::transfers.transferAcceptedmail');
    }
}
