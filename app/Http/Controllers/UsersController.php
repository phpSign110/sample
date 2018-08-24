<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //用户注册
    public function create()
    {
        return view('users.create');
    }

    //显示用户个人信息的页面
    public function show(User $user)
    {

        //var_dump($user->attributesToArray());exit;
        return view('users.show', compact('user'));
    }

    //显示所有用户列表的页面
    public function index()
    {

    }

    //用户注册操作
    public function store(Request $request)
    {

        //1.参数校验
        $this->validate($request,[
            'name'=>'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'

        ]);

        //2.保存数据
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //注册完成 自动登录
        Auth::login($user);

        //3.页面提示用户
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        //4.页面跳转
        return redirect()->route('users.show', [$user]);

    }

}
