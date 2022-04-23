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

                    <form method="GET" action="{{ route('task.index') }}">
                        <button type="submit" class="btn btn-dark">
                        一覧画面
                        </button>
                    </form>

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
                            <td>{{$task->deadline}}</td>
                            <td>{{$task->progress}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="card-body">
                        <p class="card-text">{{$task->description}}</p>
                    </div>
                    <div class="card-footer text-muted">
                        <form method="GET" action="{{route('task.edit', $task)}}">
                            @csrf
                            <input class="btn btn-success" type="submit" value="編集する">
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
