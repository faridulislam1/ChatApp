<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function sendEmail($to, $subject, $message)
    {
        try {
            Mail::raw($message, function ($mail) use ($to, $subject) {
                $mail->to($to)
                     ->subject($subject);
            });

            return "Email sent to $to";
        } catch (\Exception $e) {
            Log::error("Email sending failed: " . $e->getMessage());
            return "Email sending failed!";
        }
    }

    public function sendSms($phone, $message)
    {
        Log::info("SMS sent to $phone: $message");

        return "SMS sent to $phone";
    }
}
