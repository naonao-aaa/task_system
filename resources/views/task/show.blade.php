@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">show</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <button type="button" class="btn btn-dark" onClick="history.back()">戻る</button>
                    </div>

                    <br>
                    <div class="card">
                    <div class="card-header">
                        <h4>{{$task->name}}</h4>
                    </div>
                    <table class="table">
                        <thead>
                            <tr class="table-active">
                            <th scope="col">id</th>
                            <th scope="col">ステータス</th>
                            <th scope="col">作成者</th>
                            <th scope="col">カテゴリ</th>
                            <th scope="col">期日</th>
                            <th scope="col">進捗率</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-active">
                            <td>{{$task->id}}</td>
                            <td>{{$task->status->name}}</td>
                            <td>{{$task->user->name}}</td>
                            <td>{{$task->category->name}}</td>
                            <td>{{$task->deadline ? $task->deadline->format("Y/m/d") : ''}}</td>
                            <td>{{$task->progress}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="card-body">
                        <p class="card-text">{!! nl2br(e($task->description)) !!}</p>
                    </div>
                    <div class="card-footer text-muted">
                    @if(Auth::user()->id === $task->user_id)
                        <form method="GET" action="{{route('task.edit', $task)}}">
                            @csrf
                            <input class="btn btn-primary float-left mr-3" type="submit" value="編集する">
                        </form>

                        <form method="POST" action="{{ route('task.destroy', $task)}}" id="delete_{{ $task->id }}">
                            @csrf
                            <a href="#" class="btn btn-danger" data-id="{{$task->id}}" onclick="deletePost(this);">削除する</a>
                        </form>
                    @endif    
                    </div>
                    </div>

                    <br>
                    @foreach($comments as $comment)
                        <div class="card">
                            <div class="card-header text-muted">
                                <h7>投稿者：{{$comment->user->name}}</h7>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{!! nl2br(e($comment->text)) !!}</p>
                            </div>
                        </div>
                    @endforeach

                    <br>
                    <form method="POST" action="{{ route('comment.store', $task) }}">
                        @csrf
                        <textarea class="form-control" rows="5" name="comment"></textarea>
                        <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="task" value="{{ $task->id }}">

                        <input class="btn btn-success" type="submit" value="コメント投稿する">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    <!--
    /*************************************
    削除ボタンを押してすぐにレコードが削除
    されるのも問題なので、一旦javascriptで
    確認メッセージを流します。
    *************************************/
    //-->
    function deletePost(e){
        'use strict';
        if(confirm('本当に削除していいですか？')){
            document.getElementById('delete_'+ e.dataset.id).submit();
        }
    }
</script>

@endsection
