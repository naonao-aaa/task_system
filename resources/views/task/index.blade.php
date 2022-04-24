@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{$category}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="GET" action="{{ route('task.create') }}">
                      <button type="submit" class="btn btn-primary">
                      新規登録
                      </button>
                    </form>

                    <table class="table table-hover">
                      <thead>
                          <tr>
                          <th scope="col">id</th>
                          <th scope="col">ステータス</th>
                          <th scope="col">タスク名</th>
                          <th scope="col">作成者</th>
                          <th scope="col">締切日</th>
                          <th scope="col">更新日時</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($tasks as $task)
                          <tr>
                          <th><a href="{{ route('task.show', $task->id) }}">{{$task->id}}</a></th>
                          <td>{{$task->status->name}}</td>
                          <td><a href="{{ route('task.show', $task->id) }}">{{$task->name}}</a></td>
                          <td>{{$task->user->name}}</td>
                          <td>{{$task->deadline}}</td>
                          <td>{{$task->updated_at}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {{$tasks->appends(['category' => $categoryId])->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
