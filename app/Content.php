<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Menu;
use Illuminate\Support\Facades\DB;
use Session;

class Content extends Model
{
    static public function getAll($url, &$data)
    {
        if ($menu = Menu::where('url', '=', $url)->first()) {
            $data['content'] = Menu::find($menu->id)->contents->toArray();
            $data['title'] = $menu['title'];
        } else {
            abort(404);
        }

    }

    static public function save_new($request)
    {
        $content = new self();
        $content->article = $request['article'];
        $content->title = $request['title'];
        $content->menu_id = $request['menu_id'];

        $content->save();
        Session::flash('sm', 'Content added succcessfuly');
        Session::flash('type', 'success');
    }

    static public function update_item($request, $id)
    {
        $content = self::find($id);
        $content->title = $request['title'];
        $content->article = $request['article'];
        $content->save();
        Session::flash('sm', 'content updated succcessfuly');
        Session::flash('type', 'success');
    }

    //get content details for cpanel
    static public function getContent(&$data)
    {

        $data['contents'] = DB::table('contents AS c')
            ->join('menus AS m' , 'm.id' , '=' ,'c.menu_id')
            ->get()
            ->toArray();
    }
}
