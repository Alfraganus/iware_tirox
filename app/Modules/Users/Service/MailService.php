<?php

namespace App\Modules\Users\Service;

use Illuminate\Support\Facades\Mail;

class MailService
{
    public static function sendMail(String $template, $code, $payload,$subject)
    {
        Mail::send($template, ['code' => $code], function ($message) use ($payload, $code,$subject) {
            $message->from('noreply@avlomuslim.com', 'Avlo Muslim App');
            $message->to($payload['email']);
            $message->subject($subject);
        });
    }

}
