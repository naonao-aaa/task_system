@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">edit</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('task.update', $task->id)}}">
                        @csrf    
                        <div class="form-group">
                            タスク名<br>
                            <input type="text" class="form-control" name="task_name" value="{{ $task->name }}">
                            <br>
                            タスク説明文<br>
                            <textarea class="form-control" rows="10" name="description">{{ $task->description }}</textarea>

                            <br>
                            登録者：{{ $task->adminUser->name }}
                            <input type="hidden" name="admin_user" value="{{ $task->adminUser->id }}">
                            <br>
                            担当者：{{ $task->workUser->name }}
                            <input type="hidden" name="work_user" value="{{ $task->workUser->id }}">
                            <br>

                            <br>
                            進捗度<br>
                            <input type="integer" name="progress" value="{{ $task->progress }}">
                            <br>
                            工数<br>
                            <input type="integer" name="man_hours" value="{{ $task->man_hours }}">
                            <br>
                            <br>
                            ステータス<br>
                            <select name="status">
                                    <option value="">選択してください</option>
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}" @if($task->status_id===$status->id) selected @endif>{{$status->name}}</option>
                                @endforeach
                            </select>
                            <br>
                            カテゴリ<br>
                            <select name="category">
                                    <option value="">選択してください</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"  @if($task->category_id===$category->id) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>

                            <br>
                            締切日<br>
                            <input type="date" name="deadline" value="{{ $task->deadline ? $task->deadline->format('Y-m-d') : '' }}">
                            {{--input type="date" に初期値を設定するには、フォーマットをY-m-dの形にする必要がある。--}}{{--$task->deadlineがNULLのレコードの考慮も忘れずに三項演算子用いる--}}
                            <br>

                            <br>
                            <input class="btn btn-info" type="submit" value="更新する">
                        </div>
                    </form>
                    <br>
                    <form method="GET" action="{{ route('task.index') }}">
                        <button type="submit" class="btn btn-dark">
                        一覧画面
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
