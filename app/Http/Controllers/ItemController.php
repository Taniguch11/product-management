<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Image;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index()
    {
        // itemsテーブルのレコードをすべて取得
        // ソート機能とページネーションを設定
        $items = Item::sortable()->paginate(10)->withQueryString();

        return view('item.index', compact('items'));
    }
    
    /**
     * 商品検索
     */
    public function search(Request $request)
    {
        // itemsテーブルのレコードをすべて取得
        // ソート機能とページネーションを設定
        $items = Item::sortable()->paginate(10)->withQueryString();

        //キーワード受け取り
        $keyword = $request->input('keyword');

        //クエリ生成
        $query = Item::query();

        //もしキーワードがあったら
        if(!empty($keyword))
        {
            $query->where('name','like','%'.$keyword.'%');
            $query->orWhere('type','like','%'.$keyword.'%');
            $query->orWhere('price','like','%'.$keyword.'%');
            $query->orWhere('detail','like','%'.$keyword.'%');

            $items = $query->paginate(10);
        }
        return view('item.search', compact('items', 'keyword'));
    }

    /**
     * 商品登録
     */
    public function create(Request $request)
    {
        $items = new Item();
        return view('item.create', compact('items'));
    }

    public function store(Request $request)
    {
        // POSTリクエストのとき
        // if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

        // 画像フォームでリクエストした画像を取得
        $img = $request->file('img_path');
        // TODO:画像投稿を必須にしない場合はnullを初期値にしてif文に入る
        // $img_path = null;

        if (isset($img)) {
            // storage > public > img配下に保存
            $path = $img->store('img', 'public');
        }
        Item::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'detail' => $request->detail,
            'img_path' => $path,
        ]);

        return redirect()->route('items.index');
    }

    /**
     * 商品編集
     */
    public function edit($id)
    {
        $item = Item::find($id);
        return view('item.edit', compact('item'));
        // POSTリクエストのとき
        // if ($request->isMethod('post')) {
            // バリデーション
            // $this->validate($request, [
            //     'name' => 'required|max:100',
            // ]);
        
            // 商品編集
            // Item::update([
            //     'user_id' => Auth::user()->id,
            //     'name' => $request->name,
            //     'type' => $request->type,
            //     'detail' => $request->detail,
            // ]);
    }
        // 編集処理
        public function update(Request $request, $id)
        {
            // 既存のレコードを取得して、編集してから保存する
            $item = Item::find($id);

            if($request->file('img_path')){
                // storage > public > img配下に保存
                $path = $img->store('img', 'public');
            }
            $item->name = $request->name;
            // $item->category_id = $request->category_id;
            $item->price = $request->price;
            $item->detail = $request->detail;
            // $item->img_path = $path;
            $item->save();

            return redirect()->route('items.index');
        }

    /**
     * 商品削除
     */
    public function destroy($id)
    {
        // 既存のレコードを取得して、削除する
        $item = Item::find($id);
        $item->delete();

        return redirect()->route('items.index');
    }
}
