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
                            作成者：{{ Auth::user()->name }}
                            <input type="hidden" name="user" value="{{ Auth::user()->id }}">
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
                                <option value="1" @if($task->status_id===1) selected @endif>新規</option>
                                <option value="2" @if($task->status_id===2) selected @endif>進行中</option>
                                <option value="3" @if($task->status_id===3) selected @endif>完了</option>
                                <option value="4" @if($task->status_id===4) selected @endif>終了</option>
                            </select>
                            <br>
                            カテゴリ<br>
                            <select name="category">
                                <option value="">選択してください</option>
                                <option value="1" @if($task->category_id===1) selected @endif >ECサイト</option>
                                <option value="2" @if($task->category_id===2) selected @endif >オンラインサロン</option>
                                <option value="3" @if($task->category_id===3) selected @endif >SNSサイト</option>
                                <option value="4" @if($task->category_id===4) selected @endif >予約システム</option>
                                <option value="5" @if($task->category_id===5) selected @endif >社内管理システム</option>
                            </select>

                            {{-- $task->deadlineはdate型なのだが、フツーに表示させると2022-04-23 00:00:00のように表示される。これを2022-04-23のように表示変換させないとvalueで表示されない。これを後ほど調べる。 --}}
                            <br>
                            締切日<br>
                            <input type="date" name="deadline" value="{{ $task->deadline }}"> 前回保存締切日:{{ $task->deadline }}
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
