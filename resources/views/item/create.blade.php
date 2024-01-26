@extends('adminlte::page')

@section('title', 'MOVIE ADDITION')

@section('content_header')
    <h1>MOVIE ADDITION</h1>
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
                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                        <label for="name">{{ __('タイトル') }}</label><br>
                        <span class="badge badge-danger rounded-pill ml-2">{{ __('必須') }}</span>
                            <input type="text" class="form-control" id="name" name="name" placeholder="映画のタイトル">
                        </div>

                        <div class="form-group">
                            <label for="category-id">{{ __('カテゴリー') }}</label><br>
                                <span class="badge badge-danger rounded-pill ml-2">{{ __('必須') }}</span>
                            <select class="form-control" id="category-id" name="category_id">
                            <option value="">選択してください</option>
                            @foreach (config("category") as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="price">{{ __('公開年') }}</label><br>
                                <span class="badge badge-danger rounded-pill ml-2">{{ __('必須') }}</span>
                            <input type="number" class="form-control" id="price" name="price" placeholder="2024/1/5
                            ">
                        </div>

                        <div class="form-group">
                            <label for="cast">キャスト</label>
                            <input type="text" class="form-control" id="cast" name="cast" placeholder="メインキャスト、注目の俳優など">
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明">
                        </div>

                        <!-- 画像投稿フォーム -->
                        <div class="form-group">
                            <label for="img_path">{{ __('商品画像') }}</label><br>
                                <span class="badge badge-danger rounded-pill ml-2">{{ __('必須') }}</span>
                            <br>
                            <input type="file" name="img_path" class="form-control-file">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
