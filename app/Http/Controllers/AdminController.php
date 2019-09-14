<?php

namespace App\Http\Controllers;

use App\Mail;
use App\Order;
use App\User;

use Illuminate\Http\Request;
use DB;

class AdminController extends MainController
{

    function __construct(){
        parent::__construct();
        $this->middleware('AdminGuard',['except' => ['logout']]);
    }

    public function admin(){
self::$data['users'] = User::all();
self::$data['orders'] = Order::all();
self::$data['contacts'] = Mail::all();


        return view('admin.dash',self::$data);
    }
    public function getCategories(){
        return view('admin.categories');
    }
    public function deleteContact(Request $request){

        DB::table('mails')
            ->where('id' , '=' , $request['id'])
            ->delete();


    }
    public function getOrders(){


        Order::getOrder(self::$data);
        return view('admin.orders',self::$data);
    }

}
