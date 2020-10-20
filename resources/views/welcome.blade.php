@extends("layouts.app")

@section("content")
    @if (Auth::check())
        <div class="row">
            <aside class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">ログインユーザー：{{Auth::user()->name }}</h3>
                    </div>
                </div>
            </aside>
            <div class="col-sm-8">
                {{--タスク一覧--}}
                @include("tasks.tasks")
                
                {{-- タスク作成ページへのリンク--}}
                {!! link_to_route("tasks.create","新規タスクの登録",[],["class" =>"btn btn-primary"]) !!}
            </div>
        </div>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to Tasklist</h1>
                {{--ユーザ登録ページへのリンク--}}
                {!! link_to_route("signup.get","Sign up now!",[],["class" => "btn btn-lg btn-primary"]) !!}
            </div>
        </div>
    @endif
@endsection