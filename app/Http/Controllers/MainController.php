<?php

namespace App\Http\Controllers;

use App\Footer_link;
use App\Footer_menu;
use App\product;
use Egulias\EmailValidator\Warning\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Menu;
use Illuminate\Session;


class MainController extends Controller
{


    public static $data = [];

    function __construct()
    {
        self::$data['menu'] = Menu::all()->toArray();
        self::$data['comments'] = DB::table('comments AS c')
            ->join('blogs AS b','c.bid' , '=' ,'b.id')
            ->get()
            ->toArray();
        self::$data['title'] = '';
        self::$data['content'] = '';
    }


    public function searchItem(Request $request)
    {

        $products['search'] = DB::table('products AS p')
            ->join('categories AS c', 'p.c_id', '=', 'c.id')
            ->select('p.p_name', 'p.p_url', 'c.c_url')
            ->where('p.p_name', 'LIKE', '%' . $request['search'] . '%')
            ->get()
            ->toArray();

        return view('app/search', $products);

    }


}
