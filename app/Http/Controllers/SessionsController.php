<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    //显示用户登录页面
    public function create()
    {
        return view('sessions.create');
    }

    //用户登录操作
    public function store(Request $request)
    {

        //数据校验
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);


        if(Auth::attempt($credentials,$request->has('remember'))){ //如果认证成功
            session()->flash('success', '欢迎回来！');
            return redirect()->route('users.show', [Auth::user()]);

        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }

    }

    //用户退出
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');

    }

}
