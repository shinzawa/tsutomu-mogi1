<?php

namespace App\Http\Controllers;

use App\Mail\MailTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailTest extends Controller
{
    public function index()
    {
        return view('mail.test');
    }

    public function send()
    {
        $to = 'recipient@example.com';
        $data = ['message' => 'this is a test email.'];

        Mail::to($to)->send(new MailTest($data));

        return 'メールが送信されました。';
    }
}
