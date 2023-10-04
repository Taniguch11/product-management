@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
            @if(empty($items))
                <p class="p-3">登録が0件です</p>
            @endif
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
                                <th scope="col">@sortablelink('type', 'カテゴリー')</th>
                                <th scope="col">@sortablelink('price', '価格')</th>
                                <th>詳細</th>
                                <th>商品写真</th>
                                <th scope="col">@sortablelink('created_at', '作成日')</th>
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
                                    <td><img src="{{ asset('/storage/' . $item->img_path) }}" width="10%"></td>
                                    <td><small>{{$item->created_at}}</small></td>
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

                    {!! $items->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .badge {
    display: none;
    }
    .badge.is-show {
        display: inline-block;
    }
</style>
@stop

@section('js')
<script>
    // newアイコンの表示日数 
    var periodDay = 1;

    var current = new Date();
    var postdate = document.querySelectorAll('[data-postdate]');
    for (var i = 0; i < postdate.length; i++) {
        var d = new Date(postdate[i].dataset.postdate);
        d.setDate(d.getDate() + periodDay);
    if(current < d) {
        postdate[i].classList.add('is-show');
    }
}
</script>
@stop
