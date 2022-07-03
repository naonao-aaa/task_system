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

                    <form method="POST" action="{{ route('task.update', $task->id)}}">
                        @csrf    
                        <div class="form-group">
                            タスク名<br>
                            @if($errors->has('task_name'))
                                <div class="alert alert-danger">
                                    @foreach($errors->get('task_name') as $error)
                                        ・{{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <input type="text" class="form-control" name="task_name" value="{{ $task->name }}">
                            <br>

                            タスク説明文<br>
                            @if($errors->has('description'))
                                <div class="alert alert-danger">
                                    @foreach($errors->get('description') as $error)
                                        ・{{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
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
                            @if($errors->has('progress'))
                                <div class="alert alert-danger">
                                    @foreach($errors->get('progress') as $error)
                                        ・{{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <input type="integer" name="progress" value="{{ $task->progress }}">

                            <br>
                            工数<br>
                            @if($errors->has('man_hours'))
                                <div class="alert alert-danger">
                                    @foreach($errors->get('man_hours') as $error)
                                        ・{{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <input type="integer" name="man_hours" value="{{ $task->man_hours }}">
                            <br>

                            <br>
                            ステータス<br>
                            @if($errors->has('status'))
                                <div class="alert alert-danger">
                                    @foreach($errors->get('status') as $error)
                                        ・{{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <select name="status">
                                    <option value="">選択してください</option>
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}" @if($task->status_id===$status->id) selected @endif>{{$status->name}}</option>
                                @endforeach
                            </select>

                            <br>
                            カテゴリ<br>
                            @if($errors->has('category'))
                                <div class="alert alert-danger">
                                    @foreach($errors->get('category') as $error)
                                        ・{{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
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
