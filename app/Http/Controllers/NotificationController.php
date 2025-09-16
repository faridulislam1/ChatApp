<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Notification; 


class NotificationController extends Controller
{
   public function notify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'email_subject' => 'required|string',
            'email_message' => 'required|string',
            'sms_message' => 'required|string'
        ]);

        $emailStatus = Notification::sendEmail(
            $request->email,
            $request->email_subject,
            $request->email_message
        );

        $smsStatus = Notification::sendSms(
            $request->phone,
            $request->sms_message
        );

        return response()->json([
            'email' => $emailStatus,
            'sms' => $smsStatus
        ]);
    }
}
