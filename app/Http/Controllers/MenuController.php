<?php

namespace App\Http\Controllers;

use DemeterChain\Main;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Menu;
use Session;
class MenuController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.menu' , self::$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_menu' , self::$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        Menu::save_new($request);
        return redirect('admin/menu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        self::$data['item_id'] = $id;
        return view('admin.delete_menu' , self::$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        self::$data['menu_item'] = Menu::find($id)->toArray();
        return view('admin.edit_menu' , self::$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $id)
    {

        Menu::update_item($request , $id);
        return redirect('admin/menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Menu::destroy($id);
       Session::put('sm' , 'menu delted successfully');
       Session::put('type' , 'success');
       return redirect('admin/menu');
    }
}
