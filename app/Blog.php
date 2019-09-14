<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB,Session;

class Blog extends Model
{
    static public function getBlog($burl, &$data)
    {
        $data['blog'] = Blog::find($burl)->first()->toArray();
        $data['comments'] = DB::table('comments AS c')
            ->where('bid', '=', $burl)
            ->join('users AS u', 'u.id', '=', 'c.uid')
            ->paginate(3);

    }

    static public function addComment($request)
    {
        $comment = DB::table('comments')
            ->insert([
                'uid' => $request['uid'],
                'bid' => $request['bid'],
                'comment' => $request['comment']
            ]);
        Session::put('sm', 'commented successfully');
        Session::put('type', 'success');

    }

    static public function save_new($request)
    {

        $image_name = 'noimage.png';
        if ($file = $request->file('image')) {
            $name = date('Y.m.d.H.i.s') . '-' . $file->getClientOriginalName();
            $image_name = $name;

            $file->move(public_path() . '/images/', $name);
        }
        $blog = new self();
        $blog->title = $request['title'];
        $blog->content = $request['content'];
        $blog->image = $image_name;
        $blog->save();
        Session::flash('sm' , 'post added succcessfuly');
        Session::flash('type' , 'success');
    }

    static public function update_item($request, $id)
    {
        $image_name = 'noimage.png';
       if ($request->file('image') != null ){
           if ($file = $request->file('image')) {
               $name = date('Y.m.d.H.i.s') . '-' . $file->getClientOriginalName();
               $image_name = $name;
           }
           $file->move(public_path() . '/images/', $name);
       }
        $blog = self::find($id);
        $blog->title = $request['title'];
        $blog->content = $request['content'];
        $blog->image = $image_name;
        $blog->save();
        Session::flash('sm' , 'post edited succcessfuly');
        Session::flash('type' , 'success');
        }
}
