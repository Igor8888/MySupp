<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB, Session;
use Illuminate\Support\Facades\Hash;

class User extends Model
{

    //the log in
    static public function validateUser($email, $password)
    {
        $valid = false;

        $user = DB::table('users AS u')
            ->join('user_rols AS ur', 'u.id', '=', 'ur.u_id')
            ->where('u.email', '=', $email)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            $valid = true;
            Session::put('user_id', $user->id);
            Session::put('user_email', $user->email);
            Session::put('user_rol', $user->r_id);
            Session::put('user_name', $user->name);
            Session::put('email', $user->email);
            if ($user->r_id == 7) Session::put('is_admin', true);
            Session::flash('sm', 'Welcome back ' . $user->name);
            Session::flash('sb', '');
            Session::flash('type', 'success');
        }


        return $valid;
    }

    static public function save_new($request)
    {


        $user = new self();
        $user->name = $request['first-name'] . ' ' . $request['last-name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();
        $id = DB::table('users')
            ->select('id')
            ->orderBy('id', 'desc')
            ->first();
        $user_rol = DB::table('user_rols')
            ->insert(['u_id' => $id->id, 'r_id' => 6]);
    }

    static public function update_item($request, $id)
    {
        $user = self::find($id);
        $user->name = $request['first-name'] . ' ' . $request['last-name'];
        $user->email = $request['email'];
        if (!empty($request['password'])){
            $user->password = bcrypt($request['password']);
        }

        $user->save();
        $user = $user->toArray();
        $user_rol = DB::table('user_rols')
            ->where('u_id' , '=' , $user['id'])
            ->update(['r_id' => $request['userRol']]);

        Session::flash('sm', 'user edited succcessfuly');
        Session::flash('type', 'success');
    }
}
