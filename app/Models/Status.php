<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['content'];

    //指明一个微博只能有一个用户
    public function user()
    {
      return $this->belongsTo(User::class);

    }
}
