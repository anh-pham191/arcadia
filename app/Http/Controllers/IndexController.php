<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function postContact(Request $request){
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $subject = $request->subject;
        $mess = $request->message;
        $exception = 'sdf';
        Mail::send('mail', ['subject' => $subject, 'name' => $name, 'mess' => $mess , 'phone' => $phone, 'email' => $email], function ($message) {
            $message->to('tuananh191194@gmail.com'
                , 'harvey.ho@auckland.ac.nz', 'harvey.nz@gmail.com'
            )->subject('New contact submission from 3d-fetus.org');
        });
        return view('welcome');
    }
}
