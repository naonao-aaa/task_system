<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //Modelで扱うカラム名（カラムに対応する変数名）を設定します。このプロパティに無い変数名は無視されるようになります。
    protected $fillable = [
        'id', 'name'
    ];
}
