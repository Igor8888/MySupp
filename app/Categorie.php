<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Session;
use Illuminate\Http\Request;

class Categorie extends Model
{
    static public function getRecent(&$data)
    {
        $recent = DB::table('products AS p')
            ->join('categories AS c', 'c.id', '=', 'p.c_id')
            ->select('p.*', 'c.c_url')
            ->orderBy('id', 'desc')
            ->limit(3)
            ->offset(0)
            ->get()->toArray();
        $recent = json_decode(json_encode($recent), true);
        if (!empty($recent)) {
            $data['recent'] = $recent;
            } else {
            $data['recent'] = '';
        }
    }

    static public function update_item($request, $id)
    {

        $image_name = 'noimage.png';

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $file = $request->file('image');
            $image_name = date('Y.m.d.H.i.s') . '-' . $file->getClientOriginalName();
            $request->file('image')->move(public_path() . '/images/' , $image_name);
        }


        $category = self::find($id);
        $category->c_name = $request['name'];
        $category->c_description = $request['description'];
        $category->c_url = $request['url'];
        $category->c_img = $image_name;
        $category->save();
        Session::flash('sm', 'categorie updated succcessfuly');
        Session::flash('type', 'success');
    }

    static public function save_new($request)
    {


        $image_name = 'noimage.png';

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $file = $request->file('image');
            $image_name = date('Y.m.d.H.i.s') . '-' . $file->getClientOriginalName();
            $request->file('image')->move(public_path() . '/images/' , $image_name);
        }

        $category = new self();
        $category->c_name = $request['name'];
        $category->c_description = $request['description'];
        $category->c_url = $request['url'];
        $category->c_img = $image_name;
        $category->save();
        Session::flash('sm' , 'Category created succcessfuly');
        Session::flash('type' , 'success');
    }
}
