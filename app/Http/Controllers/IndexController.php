<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Contact;

class IndexController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function threed()
    {
        return view('smoke');
    }

    public function lung()
    {
        return view('lung');
    }

    public function postContact(Request $request){
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $subject = $request->subject;
        $mess = $request->message;
        Contact::create([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'subject' => $subject,
            'message' => $mess
        ]);

        $exception = 'sdf';
        Mail::send('mail', ['subject' => $subject, 'name' => $name, 'mess' => $mess , 'phone' => $phone, 'email' => $email], function ($message) {
            $message->to("harvey.nz@gmail.com")->cc('harvey.ho@auckland.ac.nz')->cc('tuananh191194@gmail.com')
            ->subject('New contact submission from 3d-fetus.org');
        });
        return view('welcome');
    }
}
