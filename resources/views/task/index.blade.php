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

                    <form method="GET" action="{{route('task.index')}}" class="form-inline my-2">
                      <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
                      <input type="hidden" name="category" value="{{$categoryId}}">   {{--カテゴリ毎で検索できるように、categoryのパラメータも追加する。（method="GET"のform内のinputタグで設定したものは、全てパラメータに並ぶことになる）--}}
                      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
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
                          <td>{{ $task->deadline ? $task->deadline->format("Y/m/d") : '' }}</td>  {{-- $task->deadlineはnullable設定をしているので、NULLのレコードを考慮して三項演算子を用いる --}}
                          <td>{{ $task->updated_at->format("Y/m/d") }}</td>  {{-- $task->updated_atは、nullable設定をしていないためNULLのレコードは無いため、NULLを考慮しないでOK --}}
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
