<?php

namespace App;

//use DB, Session, Cart;
//use App\Categorie;
//use Illuminate\Http\UploadedFile;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model{

    static public function save_new($request){
        $mail = new self();
        $mail->name = $request['name'];
        $mail->email = $request['email'];
        $mail->phone = $request['phone'];
        $mail->subject = $request['subject'];
        $mail->message = $request['messege'];
        $mail->save();
    }

}
