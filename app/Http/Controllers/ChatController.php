<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(){
        return view('Welcome');
    }
    public function broadcast(Request $request)
    {
        event(new \App\Events\Chat($request->msg, $request->username));
        return response()->json($request->all());
    }
    public function chat(Request $request) {

        $username=$request->username;
        return view('chat')->with(['username'=> $username]);
    }

}
