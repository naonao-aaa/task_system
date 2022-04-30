<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //Modelで扱うカラム名（カラムに対応する変数名）を設定します。このプロパティに無い変数名は無視されるようになります。
    protected $fillable = [
        'id', 'name', 'description', 'admin_user', 'work_user', 'category_id', 'status_id', 'progress', 'man_hours', 'deadline'
    ];

    //casts（型を変換することをキャストという。DBの日時・日付型はphpでは文字列として扱われるが、この設定をすることで自動でそれぞれの型に変換してくれる。）
    protected $casts = [
        'deadline' => 'date'
    ];

    //リレーション設定
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function adminUser()
    {
        return $this->belongsTo('App\User', 'admin_user');
    }

    public function workUser()
    {
        return $this->belongsTo('App\User', 'work_user');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }
}
