<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;
use Session;
use App\Http\Requests\CategoryRequest;
use App\product;
use App\Http\Requests\ProductRequest;

class ProductController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        product::ManageProducts(self::$data);
        //dd(self::$data['products'])


        self::$data['categories'] = Categorie::all()->toArray();


        return view('admin.products', self::$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        self::$data['categories'] = Categorie::all()->toArray();
        return view('admin.add_product', self::$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        product::save_new($request);
        return redirect('admin/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        self::$data['item_id'] = $id;
        return view('admin.delete_product', self::$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        self::$data['menu_item'] = product::find($id)->toArray();
        self::$data['categories'] = Categorie::all()->toArray();

        return view('admin.edit_product', self::$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {

        product::update_item($request, $id);
        return redirect('admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        product::destroy($id);
        Session::put('sm', 'product delted successfully');
        Session::put('type', 'success');
        return redirect('admin/products');
    }

    public function chooseCategory(ProductRequest $request)
    {

    }

}
