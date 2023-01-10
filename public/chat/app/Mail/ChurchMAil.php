<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChurchMAil extends Mailable
{
    use Queueable, SerializesModels;
    public $church;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($church)
    {
        $this->church = $church;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Church Details Create!')
                    ->markdown('emails.church.newCreate');
        // return $this->markdown('emails.church.newCreate');
    }
}
