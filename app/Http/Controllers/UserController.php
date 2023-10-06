<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * プロフィール編集画面表示
     */
    public function show()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * プロフィール編集機能（ユーザー名、メールアドレス）
     */
        // public function setting(Request $request, $id)
        // {
        //     $user = User::find($id);

        //     // リクエストデータ受取
        //     $form = $request->all();
        //     // フォームトークン削除
        //     unset($form['_token']);
        //     // レコードアップデート
        //     $user->fill($form)->save();

        //     return redirect()->route('user.show');
        // }

    public function profileUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
        ]);

        try {
            $user = Auth::user();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

        } catch (\Exception $e) {
            return back()->with('msg_error', 'プロフィールの更新に失敗しました')->withInput();
        }

        return redirect()->route('profile')->with('msg_success', 'プロフィールの更新が完了しました');
    }
    
    /**
     * パスワード編集機能
     */
    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = Auth::user();
            $user->password = bcrypt($request->input('password'));
            $user->save();

        } catch (\Exception $e) {
            return back()->with('msg_error', 'パスワードの更新に失敗しました')->withInput();
        }

        return redirect()->route('profile')->with('msg_success', 'パスワードの更新が完了しました');
    }
}
