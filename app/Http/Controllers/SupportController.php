<?php

namespace App\Http\Controllers;

use App\Mail\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'question' => 'required',
        ]);

        Mail::to('example@example.com')->send(
            new SupportTicket(request('email'), request('question'))
        );

        session()->flash('message', ['message send!', 'we will get back to you as soon as possible']);

        return redirect('/');
    }
}
