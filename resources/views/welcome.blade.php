@extends("layouts.app")

@section("content")
    @if (Auth::check())
        <div class="row">
            <aside class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{Auth::user()->naem }}</h3>
                    </div>
                </div>
            </aside>
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