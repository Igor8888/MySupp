<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Categorie;
use Session;
use App\Http\Requests\CategoryRequest;

class CategorieController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        self::$data['categories'] = Categorie::all()->toArray();

        return view('admin.categories', self::$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_category', self::$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Categorie::save_new($request);
        return redirect('admin/categories');
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
        return view('admin.delete_category', self::$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        self::$data['menu_item'] = Categorie::find($id)->toArray();
        return view('admin.edit_category', self::$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {

        Categorie::update_item($request, $id);
        return redirect('admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Categorie::destroy($id);
        Session::put('sm', 'category delted successfully');
        Session::put('type', 'success');
        return redirect('admin/categories');
    }




}
