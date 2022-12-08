<?php

namespace Modules\Registrar\emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseTransferMails extends Mailable
{

    use Queueable, SerializesModels;
    public $newRecord;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newRecord)
    {
         $this->$newRecord =  $newRecord;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Successful Course Transfer')->view('registrar::transfers.transferAcceptedmail');
    }
}
