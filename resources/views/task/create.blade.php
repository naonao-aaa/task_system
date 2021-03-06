@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">create</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('task.store') }}">
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
                            <input type="text" class="form-control" name="task_name" value="{{old('task_name')}}">
                            <br>

                            タスク説明文<br>
                            @if($errors->has('description'))
                                <div class="alert alert-danger">
                                    @foreach($errors->get('description') as $error)
                                        ・{{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <textarea class="form-control" rows="10" name="description">{{old('description')}}</textarea>
                            <br>

                            登録者：{{ Auth::user()->name }}
                            <input type="hidden" name="admin_user" value="{{ Auth::user()->id }}">
                            <br>

                            <br>
                            担当者<br>
                            @if($errors->has('work_user'))
                                <div class="alert alert-danger">
                                    @foreach($errors->get('work_user') as $error)
                                        ・{{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <select name="work_user">
                                    <option value="">選択してください</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" {{ $user->id == old('work_user') ? 'selected' : '' }}>{{$user->name}}</option>
                                @endforeach
                            </select>

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
                                    <option value="{{$status->id}}" {{ $status->id == old('status') ? 'selected' : '' }}>{{$status->name}}</option>
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
                                    <option value="{{$category->id}}" {{ $category->id == old('category') ? 'selected' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>

                            {{-- 進捗度 --}}
                            <input type="hidden" name="progress" value="0">
                            <br>

                            締切日<br>
                            <input type="date" name="deadline" value="{{old('deadline')}}">
                            <br>

                            <br>
                            <input class="btn btn-info" type="submit" value="登録する">
                        </div>
                    </form>
                    <br>
                    <div>
                        <button type="button" class="btn btn-dark" onClick="history.back()">戻る</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
