<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskForm extends FormRequest
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
            'status' => 'required|integer|exists:App\Status,id',
            'category' => 'required|integer|exists:App\Category,id',
            'progress' => 'integer|nullable|max:100',
            'man_hours' => 'integer|nullable',
        ];
    }

    public function attributes()
    {
        return [
            'task_name' => 'タスク名',
            'description' => 'タスク説明文',
            'status' => 'ステータス',
            'category' => 'カテゴリ',
            'progress' => '進捗度',
            'man_hours' => '工数',
        ];
    }
}
