<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //Modelで扱うカラム名（カラムに対応する変数名）を設定します。このプロパティに無い変数名は無視されるようになります。
    protected $fillable = [
        'id', 'name'
    ];

    //リレーション設定
    public function task()
    {
        return $this->hasMany('App\Task');
    }
}
