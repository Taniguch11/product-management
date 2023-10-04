@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
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
                            <label for="name">名前</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="商品名">
                        </div>

                        <div class="form-group">
                            <label for="category-id">{{ __('カテゴリー') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
                            <select class="form-control" id="category-id" name="category_id">
                            <option value="">選択してください</option>
                            @foreach (config("category") as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="price">価格</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="1000">
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明">
                        </div>
                    </div>
                        <!-- 画像投稿フォーム -->
                        <input type="file" name="img_path">

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">登録</button>
                        </div>
                    </form>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
