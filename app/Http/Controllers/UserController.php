<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::all();
        $users = User::all();
        return view("admins.index", compact(['users', 'roles']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.createuser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'user_first_name' => 'required',
            'user_last_name' => 'required',
            'email' => 'unique:users,email',
        ]);
        // $password = Hash::make($request->password);
        $generatedPassword = 'official';

        User::create([
            'user_first_name' => $request->user_first_name, 'user_last_name' => $request->user_last_name, 'email' => $request->email, 'password' => Hash::make($generatedPassword), 'user_status' => 1, 'deleted' => 0, 'created_by' => Auth::user()->id,
            'role' => 'official',
        ]);

        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $users = User::find($id);

        return view('admins.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate(request(), [
            'user_first_name' => 'required',
            'user_last_name' => 'required',
            'email' => 'required',
            'user_status' => 'required',
        ]);
        //posting to database

        User::where('id', $id)->update(request(['user_first_name', 'user_last_name', 'email', 'user_status']));

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        User::where('id', $id)->update(['deleted' => 1, 'deleted_on' => date('Y-m-d H-i-s'), 'deleted_by' => Auth::user()->id]);

        return redirect('/users');
    }
    public function loggedUser()
    {
        return view('admins.loggedusers');
    }
}
