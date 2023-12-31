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
                <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('上書きします。よろしいですか？');">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}">
                        </div>

                        <div class="form-group">
                            <label for="category-id">カテゴリー</label>
                            <select class="form-control" id="category-id" name="category_id">
                            @foreach (config("category") as $key => $value)
                                <option value="{{ $key }}" {{ $key == $item->category_id ? "selected" : null }}>{{ $value }}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price">価格</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ $item->price }}">
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" value="{{ $item->detail }}">
                        </div>

                        <div class="form-group">
                            <label for="detail"></label>
                            <img src="data:img_path/png;base64,{{ $item->img_path }}" width=25%>
                        </div>

                        <div class="form-group">
                            <label for="img_path"></label>
                            <br>
                            <input type="file" name="img_path">
                        </div>
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
