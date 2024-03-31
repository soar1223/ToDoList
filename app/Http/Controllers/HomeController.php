<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;

class HomeController extends Controller
{
    public function index()
{
    // ログインユーザーを取得する
    $user = Auth::user();

    // ログインユーザーに紐づくフォルダを一つ取得する
    $folder = $user->folders()->first();

    // まだ一つもフォルダを作っていなければ、フォルダ作成画面へのリンクを含むホームページをレスポンスする
    if (is_null($folder)) {
        return view('home', ['user' => $user]);
    }

    // フォルダがあればそのフォルダのタスク一覧にリダイレクトする
    return redirect()->route('tasks.index', ['id' => $folder->id]);
}

}