@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    createです
                    <form method="POST" action="{{ route('task.store') }}">
                    @csrf    
                        タスク名<br>
                        <input type="text" name="task_name">
                        <br>
                        タスク説明文<br>
                        <textarea name="description"></textarea>
                        <br>
                        作成者：{{ Auth::user()->name }}
                        <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                        <br>
                        ステータス<br>
                        <select name="status">
                            <option value="">選択してください</option>
                            <option value="1">新規</option>
                            <option value="2">進行中</option>
                            <option value="3">完了</option>
                            <option value="4">終了</option>
                        </select>
                        <br>
                        カテゴリ<br>
                        <select name="category">
                            <option value="">選択してください</option>
                            <option value="1">ECサイト</option>
                            <option value="2">オンラインサロン</option>
                            <option value="3">SNSサイト</option>
                            <option value="4">予約システム</option>
                            <option value="5">社内管理システム</option>
                        </select>

                        {{-- 進捗度 --}}
                        <input type="hidden" name="progress" value="0">
                        <br>

                        締切日<br>
                        <input type="date" name="deadline">
                        <br>

                        <br>
                        <input class="btn btn-info" type="submit" value="登録する">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
