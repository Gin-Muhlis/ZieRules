<?php

namespace App\Http\Controllers;

use App\Mail\sendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class MailController extends Controller
{
    public function index () {
        $mailData = [
            'title' => 'Mail From Zie Rules',
            'body' => 'This is for testing email using stmp'
        ];

        Mail::to('ginnncore717@gmail.com')->send(new sendEmail($mailData));


        dd('email send successfully');
    }
}
