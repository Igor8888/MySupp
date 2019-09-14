<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\MailRequest;
use App\Mail;
use Session, Cart, DB;
use Illuminate\Http\Request;
use App\Menu;
use App\Content;
use App\Categorie;

class PageController extends MainController
{
    public function home()
    {


        Categorie::getRecent(self::$data);

        self::$data['title'] = 'Home';
        self::$data['cart'] = Cart::getContent()->toArray();
        self::$data['blogs'] = DB::table('blogs')->limit(3)->get()->toArray();
        return view('home', self::$data);
    }

    public function getContent($url)
    {
        self::$data['url'] = $url;

        Content::getAll($url, self::$data);
        return view('content.content', self::$data);


    }

    public function contactUs()
    {
        self::$data['title'] = 'Contact us';
        return view('content.contact', self::$data);
    }

    public function getMail(MailRequest $request)
    {
        Mail::save_new($request);
        return redirect('contact-us');
    }

    public function blog()
    {
        self::$data['blogs'] = Blog::all()->toArray();
        self::$data['title'] = 'blog';
        return view('content.blog', self::$data);
    }

    public function singleBlog($burl)
    {
        Blog::getBlog($burl, self::$data);
        //dd(self::$data['comments']);
        self::$data['title'] = self::$data['blog']['title'];
        self::$data['burl'] = $burl;
        return view('content.single-blog', self::$data);
    }

    public function addComment(CommentRequest $request)
    {
        Blog::addComment($request);

        return redirect(url('blog'));


    }


}
