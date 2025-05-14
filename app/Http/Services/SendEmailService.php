<?php

namespace App\Http\Services;

use App\Mail\NotificateToLeaderBirthdayMail;
use Illuminate\Support\Facades\Mail;

class SendEmailService
{
    public static function send($type, $to, $data)
    {
        if ($type == "NotificateToLeaderBirthday") {
            Mail::to($to)->send(new NotificateToLeaderBirthdayMail($data));
        }
        return true;
    }
}