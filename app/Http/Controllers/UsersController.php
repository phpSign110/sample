<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store','index']
        ]);
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

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
       // $users = User::all();
        $users = User::paginate(5);

        return view('users.index', compact('users'));
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

    //用户编辑页面
    public function edit(User $user)
    {
        //判断授权
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    //用户更新信息
    public function update(User $user,Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        //判断授权
        $this->authorize('update', $user);


        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
    }

    //删除资源
    public function destroy(User $user)
    {
        //判断授权
        $this->authorize('destroy', $user);

        $user->delete();
        
        session()->flash('success', '成功删除用户！');
        return back();
    }
}
