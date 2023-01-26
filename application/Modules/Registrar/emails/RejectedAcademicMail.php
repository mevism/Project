<?php

namespace Modules\Registrar\emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectedAcademicMail extends Mailable
{
    use Queueable, SerializesModels;
    public $approval;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($approval)
    {
        return $this->approval  =    $approval;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Academic Leave')->view('registrar::leaves.leaveRejectedMail');
    }
}
