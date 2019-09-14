<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use Illuminate\Http\Request;
use App\Blog;
use Session , DB;

class BlogController extends MainController
{

    public function index()
    {
        self::$data['blogs'] = Blog::all()->toArray();

        return view('admin.blog', self::$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.add_blog');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        Blog::save_new($request);
        return redirect('admin/blog');
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
       return view('admin.delete_blog',self::$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        self::$data['blog'] = DB::table('blogs')
            ->where('id' , '=' , $id)
            ->first();

        return view('admin.edit_blog', self::$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, $id)
    {
        Blog::update_item($request , $id);
        return redirect('admin/blog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blog::destroy($id);
        Session::put('sm', 'post delted successfully');
        Session::put('type', 'success');
        return redirect('admin/blog');
    }
}
