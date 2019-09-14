<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class RegisterRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules(Request $request)

    {
        $ignore = !empty($request['item_id']) ? $request['item_id'] : '' ;
        return [
            'first-name' => 'required|min:2|max:50',
            'last-name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users,email,' . $ignore,
            'password' => 'required|min:6|max:20|confirmed'
        ];
    }
}
