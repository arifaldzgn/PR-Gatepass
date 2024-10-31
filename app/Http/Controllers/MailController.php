<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;


class MailController extends Controller
{
    //
    public function sendTestEmail()
    {
        $recipient = 'arifaldzgn@gmail.com';
        Mail::to($recipient)->send(new TestEmail());

        return "Test email sent successfully to $recipient";
    }
}
