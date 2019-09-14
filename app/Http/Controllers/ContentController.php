<?php

namespace App\Http\Controllers;

use DemeterChain\Main;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Menu;
use App\Content;
use Session;
use App\Http\Requests\ContentRequest;
class ContentController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        self::$data['contents'] = Content::all()->toArray();
        return view('admin.content' , self::$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_content' , self::$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentRequest $request)
    {
        Content::save_new($request);
        return redirect('admin/content');
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
        return view('admin.delete_content' , self::$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        self::$data['content_item'] = Content::find($id)->toArray();
        return view('admin.edit_content' , self::$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContentRequest $request, $id)
    {

        Content::update_item($request , $id);
        return redirect('admin/content');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Content::destroy($id);
       Session::put('sm' , 'content deleted successfully');
       Session::put('type' , 'success');
       return redirect('admin/content');
    }
}
