<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable; //消息通知相关功能
use Illuminate\Foundation\Auth\User as Authenticatable;//授权相关功能的引用

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * 白名单 只会过滤掉create 操作中由$request 提交过来的参数 不会限制save 操作
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     *
     * 隐藏返回数据中的字段
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table='users';


    //获取用户头像
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));

        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

}
