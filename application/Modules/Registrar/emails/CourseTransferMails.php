<?php

namespace Modules\Registrar\emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseTransferMails extends Mailable
{

    use Queueable, SerializesModels;
    public $student;
    public $approval;
    public $regNumber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student, $approval, $regNumber)
    {
         $this->student =  $student;
         $this->approval =  $approval;
         $this->regNumber =  $regNumber;
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
