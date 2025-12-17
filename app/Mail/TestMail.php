<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;
     public $user;
     public $link;
     public function __construct($user, $link)
        {
            $this->user = $user;
            $this->link = $link;
        }

        public function build()
        {
            return $this->subject('Password Reset Request | Sellora')
                        ->view('emails.password_reset')
                        ->with([
                            'name' => $this->user->name,
                            'link' => $this->link,
                        ]);
        }
}
