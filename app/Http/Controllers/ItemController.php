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
    public function create()
    {
        return view('item.create');
    }

    public function store(Request $request)
    {
        // POSTリクエストのとき
        // if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

        // 商品登録
        Item::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'detail' => $request->detail,
        ]);

            // 画像登録
            $img = $request->file('img_path');

            if (isset($img)) {
                // 取得したファイル名で保存 storage > public > img配下に保存
                $path = $img->store('img', 'public');
                // ファイル情報をDBに保存
                if ($path) {
                    Image::create([
                        'img_path' => $path,
                    ]);
                }
            }
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
            $item->name = $request->name;
            $item->type = $request->type;
            $item->price = $request->price;
            $item->detail = $request->detail;
    // dd($item);
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
