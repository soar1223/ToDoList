<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;
use App\Models\Folder;

use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    public function create(CreateFolder $request)
{
    // ユーザー認証を確認
    $user = Auth::user();

    if (!$user) {
        // ユーザーが認証されていない場合の処理（例：ログインページへのリダイレクト）
        return redirect()->route('login');
    }

    try {
        // フォルダモデルのインスタンスを作成して保存
        $folder = new Folder();
        $folder->title = $request->title;
        $user->folders()->save($folder);

        // リダイレクト時に成功メッセージをセッションにフラッシュする
        return redirect()->route('tasks.index', ['id' => $folder->id])
                         ->with('status', 'フォルダを作成しました。');
    } catch (\Exception $e) {
        // 例外が発生した場合のエラーハンドリング
        return back()->withInput()->withErrors(['msg' => 'フォルダの作成に失敗しました。']);
    }
}
}
