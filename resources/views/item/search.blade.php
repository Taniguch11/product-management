@extends('adminlte::page')

@section('title', '商品検索')

@section('content_header')
    <h1>商品検索</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-body">
                <form action="{{ route('items.search') }}" method="get" class="form-inline d-flex">
                    @csrf
                        <div class="flex-grow-1">
                            <input type="text" name="keyword" class="form-control w-50" placeholder="キーワード検索（名前、価格、詳細など）">
                            <input type="submit" class="btn btn-sm btn-outline-primary" value="商品検索">
                        </div>
                </form>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/create') }}" class="btn btn-primary">商品登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th scope="col">@sortablelink('id', 'ID')</th>
                                <th scope="col">@sortablelink('name', '名前')</th>
                                <th scope="col">カテゴリー</th>
                                <th scope="col">@sortablelink('price', '価格')</th>
                                <th>詳細</th>
                                <th>商品写真</th>
                                <th scope="col">@sortablelink('created_at', '作成日')</th>
                                <th scope="col">@sortablelink('updated_at', '更新日')</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td><span class="badge badge-pill badge-danger" data-postdate="{{ $item->created_at }}">NEW</span></td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ config('category')[$item->category_id] }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->detail }}</td>
                                <td><img src="data:img_path/png;base64,{{ $item->img_path }}" width=15%></td>
                                <td><small>{{$item->created_at}}</small></td>
                                <td><small>{{$item->updated_at}}</small></td>
                                <td>
                                    <div class="input-group-edit">
                                        <a href="/items/edit/{{ $item->id }}" class="btn btn-default">編集</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!-- 
                    You can use Tailwind CSS Pagination as like here:
                    {!! $items->withQueryString()->links() !!}        
                -->
                
                    {!! $items->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
                @if(empty($item))
                    <p class="p-3">登録されたデータがありません</p>
                @endif
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
