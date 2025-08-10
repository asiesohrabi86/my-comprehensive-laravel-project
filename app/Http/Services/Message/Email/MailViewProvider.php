<?php

namespace App\Http\Services\Message\Email;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;


// چون از سرویس ایمیل لاراول استفاده میکنیم، مِیلبل را ایمپلیمنت میکنیم
class MailViewProvider extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details, $subject, $from)
    {
        $this->details = $details;
        $this->subject = $subject;
        $this->from = $from;
    }

    public function build()
    {
        return $this->subject($this->subject)->view('emails.send-otp');
    }
}