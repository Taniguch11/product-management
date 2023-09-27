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
                        <div class="form-group">
                            <input type="text" name="keyword" class="form-control" placeholder="キーワード検索">
                        </div>
                        <input type="submit" class="btn btn-sm btn-outline-primary" value="商品検索">
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
                                <th>ID</th>
                                <th>名前</th>
                                <th>種別</th>
                                <th>詳細</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->detail }}</td>
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
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
