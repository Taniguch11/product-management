<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

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
        // itemsテーブルに入っているレコードをすべて取得する
        // $items = Item::all();
        $items = Item::paginate(10)->withQueryString();
        return view('item.index', compact('items'));
    }

    /**
     * ソート機能
     */
    public function list(Request $request)
    {
        $sort = $request->get('sort');
            if ($sort) {
                if ($sort === '1') {
                    $items = Item::orderBy('created_at', 'DESC')->get();
                    } elseif ($sort === '2') {
                        $items = Item::orderBy('created_at', 'ASC')->get();

                    } elseif ($sort === '3') {
                        $items = Item::orderBy('updated_at', 'DESC')->get();
                    } elseif ($sort === '4') {
                        $items = Item::orderBy('updated_at', 'ASC')->get();

                    } elseif ($sort === '5') {
                        $items = Item::orderBy('name', 'ASC')->get();
                    } elseif ($sort === '6') {
                        $items = Item::orderBy('name', 'DESC')->get();
                    }
            } else {
                $items = Item::all();
            }

        return view('item.index', compact('items', 'sort'));
    }

    /**
     * 商品検索
     */
    public function search(Request $request)
    {
        // itemsテーブルに入っているレコードをすべて取得する
        // $items = Item::all();
        $items = Item::paginate(10);

        //キーワード受け取り
        $keyword = $request->input('keyword');

        //クエリ生成
        $query = Item::query();

        //もしキーワードがあったら
        if(!empty($keyword))
        {
            $query->where('name','like','%'.$keyword.'%');
            $query->orWhere('type','like','%'.$keyword.'%');
            $query->orWhere('detail','like','%'.$keyword.'%');

            $items = $query->paginate(5);
        }
        return view('item.search', compact('items', 'keyword'));
    }

    /**
     * 商品登録
     */
    public function create(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect()->route('items.index');
        }

        return view('item.create');
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
