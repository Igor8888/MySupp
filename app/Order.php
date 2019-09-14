<?php

namespace App;

use Darryldecode\Cart\Cart;
use Illuminate\Database\Eloquent\Model;
use DB, Session;


class Order extends Model
{

    //place order to database
    public static function save_order($request)
    {


        DB::table('orders')->insert(
            [
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'content' => $request['content'],
                'paid' => $request['total']
            ]
        );


    }

    public static function getOrder(&$data)
    {
        $data['orders'] = DB::table('orders')
            ->orderBy('name', 'desc')
            ->limit(1)
            ->paginate(5);


    }
}
