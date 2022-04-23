<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //Modelで扱うカラム名（カラムに対応する変数名）を設定します。このプロパティに無い変数名は無視されるようになります。
    protected $fillable = [
        'id', 'user_id', 'task_id', 'text'
    ];

    //リレーション設定
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }
}
