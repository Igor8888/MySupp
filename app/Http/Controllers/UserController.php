<?php

namespace App\Http\Controllers;

use App\User;
use Session, Cart, DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\View\Middleware\ShareErrorsFromSession;


class UserController extends MainController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        self::$data['users'] = DB::table('users AS u')
            ->join('user_rols AS ur', 'u.id', '=', 'ur.u_id')
            ->get()
            ->toArray();
        return view('admin.user', self::$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {



        return view('admin.add_user', self::$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        User::save_new($request);
        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        self::$data['user_id'] = $id;
        return view('admin.delete_user', self::$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        self::$data['menu_item'] = User::find($id)->toArray();
        return view('admin.edit_user', self::$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegisterRequest $request, $id)
    {

        User::update_item($request, $id);
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        Session::put('sm', 'user delted successfully');
        Session::put('type', 'success');
        return redirect('admin/users');
    }


    //view the login
    public function getLogin()
    {

        self::$data['title'] = 'Login Page';
        return view('user.login', self::$data);
    }

    //login
    public function postLogin(SigninRequest $request)
    {
        if (User::validateUser($request['email'], $request['password'])) {
            return redirect('');

        } else {
            self::$data['title'] = 'Login Page';
            return view('user.login', self::$data)->withErrors('wrong email or password');
        }
    }

    public function getSignup()
    {

        return view('user.register', self::$data);
    }

    public function postSignup(RegisterRequest $request)
    {
        User::save_new($request);
        return redirect('');


    }

    public function logout()
    {
        Session::flush();
        Session::flash('sm', 'See you later');
        Session::flash('sb', 'Good bye');
        Session::flash('type', 'success');
        return redirect('user/login');

    }


}
