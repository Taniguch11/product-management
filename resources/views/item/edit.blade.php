@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品編集</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form action="{{ route('items.update', $item->id) }}" method="POST" onsubmit="return confirm('上書きします。よろしいですか？');">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}">
                        </div>

                        <div class="form-group">
                            <label for="type">種別</label>
                            <input type="text" class="form-control" id="type" name="type" value="{{ $item->type }}">
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" value="{{ $item->detail }}">
                        </div>
                        <!-- TODO:画像を表示させる -->                        
                        <div class="form-group">
                            <label for="detail">画像</label>
                            <img src="{{ Storage::url($item->img_path) }}">
                        </div>
                        <input type="file" name="img_path">

                    </div>
                    <div class="card-footer d-flex">
                            <button type="submit" class="btn btn-primary">更新</button>
                </form>
                        <form action="{{ route('items.destroy', $item->id) }}" method="post" onsubmit="return confirm('削除します。よろしいですか？');">
                            @csrf
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
