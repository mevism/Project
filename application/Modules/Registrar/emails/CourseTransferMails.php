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
    public $regNumber;
    public $document;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student, $regNumber, $document)
    {
         $this->student =  $student;
         $this->regNumber =  $regNumber;
         $this->document = $document;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->subject('Course Transfer Request')->view('registrar::transfers.transferAcceptedmail')
            /*->attach('AdmissionLetters/' . $this->document, [
                'as' => $this->document,
                'mime' => 'application/pdf',
            ])*/;
    }

}
