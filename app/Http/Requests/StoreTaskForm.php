<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'task_name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|integer|exists:App\Status,id',       //exitsはテーブル名よりもモデル名で指定する方が望ましい。
            'category' => 'required|integer|exists:App\Category,id',
            'work_user' => 'required|integer|exists:App\User,id',
        ];
    }

    public function attributes()
    {
        return [
            'task_name' => 'タスク名',
            'description' => 'タスク説明文',
            'status' => 'ステータス',
            'category' => 'カテゴリ',
            'work_user' => '担当者',
        ];
    }
}
