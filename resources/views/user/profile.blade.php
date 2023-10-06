@extends('adminlte::page')

@section('title', 'ユーザー設定')

@section('content_header')
    <h1>ユーザー設定</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="pt-2">
                <p class="h6 border-bottom border-secondary pb-3">プロフィール編集</p>
            </div>
            {!! Form::open(['route' => ['profile_edit'], 'method' => 'PUT']) !!}
            {!! Form::hidden('id',$user->id) !!}
            <div class="m-3">
                <div class="form-group">
                    {{Form::label('name','ユーザー名')}}
                    {{Form::text('name', $user->name, ['class' => 'form-control', 'id' =>'name'])}}
                    <span class="text-danger">{{$errors->first('name')}}</span>
                </div>
                <div class="form-group">
                    {{Form::label('email','メールアドレス')}}
                    {{Form::email('email', $user->email, ['class' => 'form-control', 'id' =>'email'])}}
                    <span class="text-danger">{{$errors->first('email')}}</span>
                </div>
                <div class="form-group">
                    <p><b>パスワード</b></p>
                    <div class="row g-3">
                        <div class="col-md-2">
                            <a>*****</a>
                        </div>
                        <div class="col-md-10">
                            <button type="button" class="btn btn-outline-success rounded-pill" data-toggle="modal" data-target="#Modal" id="password_edit_btn">パスワードを更新</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <p><b>前回更新日時</b></p>
                    <div class="row g-3">
                        <div class="col-md-2">
                            <a>{{ $user->updated_at }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="form-group pull-right">
                    {{Form::submit(' 更新する ', ['class'=>'btn btn-success rounded-pill'])}}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <p class="modal-title">パスワード更新</p>
                    <button class="btn-close" type="button" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => ['password_edit'], 'method' => 'PUT']) !!}
                    {!! Form::hidden('id', $user->id) !!}
                    <div class="form-group pt-1">
                        {{Form::label('password','新しいパスワード')}}
                        {{Form::password('password', ['class' => 'form-control', 'id' =>'password'])}}
                        <span class="text-danger">{{$errors->first('password')}}</span>
                    </div>
                    <div class="form-group pt-1">
                        {{Form::label('password_confirmation','新しいパスワード（確認）')}}
                        {{Form::password('password_confirmation', ['class' => 'form-control', 'id' =>'password_confirmation'])}}
                        <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                    </div>
                    <div class="w-25 d-flex">
                        <button class="btn btn-sm btn-reverse btn-outline-success rounded-pill" data-dismiss="modal">キャンセル</button>
                        {{Form::submit(' 更新する ', ['class'=>'btn btn-sm btn-success rounded-pill'])}}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <script src="{{ asset('js/modal.js') }}"></script>
    @endif
@endsection

@section('js')
<script>
    $("#password_edit_btn").on("click", function() {
        $("#Modal").modal();
    });
</script>
@stop
