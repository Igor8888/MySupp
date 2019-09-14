<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail;

class ContactController extends MainController
{
    public function index(){
        self::$data['mails'] = Mail::all()->toArray();
        return view('admin.contacts' , self::$data);
    }

    public function show($id){

        self::$data['content'] = Mail::find($id)->toArray();
        return view('admin.view-contact' , self::$data);
    }
}
