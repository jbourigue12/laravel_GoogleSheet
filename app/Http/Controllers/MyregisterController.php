<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use SheetDB\SheetDB;

class MyregisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }
    public function store()
    {
        $attributes=request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users,username',
            'email' =>  'required|email|max:255|unique:users,email',
            'password' => 'required|min:7|max:255'
        ]);
        
        $attributes['password'] = bcrypt($attributes['password']);
        User::create($attributes);
        
        $sheetdb = new SheetDB('tmararqqtmmjo');
        $sheetdb->create([
            'name'=>$attributes['name'],'username'=>$attributes['username'],'email'=>$attributes['email'],'password'=>$attributes['password']
        ]);

        return redirect('/')->with('success','');
    }
}
