<?php

namespace App\Http\Controllers;


use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use App\Categorie;
use App\product;
use App\Order;
use Cart, Session, DB;


class ShopController extends MainController
{
    public function shop()
    {
        Categorie::getRecent(self::$data);
        self::$data['cart'] = Cart::getContent()->toArray();
        self::$data['categories'] = Categorie::all()->toArray();
        self::$data['title'] = 'categories';
        return view('shop.shop', self::$data);
    }

//return the products to eaCH CATEGORIE
    public function categories(Request $request , $curl)
    {

        product::getProduct($curl, self::$data , $request);
        Categorie::getRecent(self::$data);


        self::$data['curl'] = $curl;
        self::$data['cart'] = Cart::getContent()->toArray();
        self::$data['categories'] = Categorie::all()->toArray();
        return view('shop.product', self::$data);
    }

    public function single($curl, $purl)
    {
        Categorie::getRecent(self::$data);
        self::$data['cart'] = Cart::getContent()->toArray();
        self::$data['curl'] = $curl;
        self::$data['purl'] = $purl;
        self::$data['categories'] = Categorie::all()->toArray();
        product::getSingle($purl, self::$data);
        return view('shop.single', self::$data);
    }

    public function addToCart(Request $request)
    {

        product::addToCart($request['pid'], $request['qty']);

    }

    public function updateCart(Request $request)
    {
        product::updateCart($request['pid'], $request['qty']);

    }

    public function deleteItem(Request $request)
    {
        Cart::remove($request['pid']);
        Session::flash('sm', 'Item deleted successfully');
        Session::flash('sb', 'done');
        Session::flash('type', 'success');

    }

    public function getToCart()
    {
        self::$data['cart'] = Cart::getContent();
        self::$data['cart'] = self::$data['cart']->sort()->toArray();
        self::$data['title'] = 'Check out';
        Order::getOrder(self::$data);
        //self::$data['cart'] = self::$data['cart']->sort();

        return view('shop.check', self::$data);
    }

    //place order
    public function placeOrder(OrderRequest $request)
    {


        Order::save_order($request);
        Cart::clear();
        echo $request['name'] . ','
            . $request['email'] . ','
            . $request['phone'];


    }
}
