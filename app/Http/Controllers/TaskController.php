<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function index(int $id)
{   
    
    // ユーザーのフォルダを取得する
    $folders = Auth::user()->folders;
    
    // 選ばれたフォルダを取得する
    $current_folder = Folder::find($id);
    if (is_null($current_folder)) {
        abort(404);
    }

    if (Auth::user()->id !== $current_folder->user_id) {
        abort(403);
    }
    

    // 選ばれたフォルダに紐づくタスクを取得する
    $tasks = $current_folder->tasks; 
    
    return view('tasks/index', [
        'folders' => $folders,
        'current_folder_id' => $current_folder->id,
        'tasks' => $tasks,
    ]);
}


    /**
     * GET /folders/{id}/tasks/create
     */
    public function showCreateForm(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    public function create(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    /**
     * GET /folders/{id}/tasks/{task_id}/edit
     */
    public function showEditForm(int $id, int $task_id)
    {   
        $task = Task::find($task_id);

     // タスクが見つからない場合は404エラー
     if (!$task) {
        abort(404);
    }

    // タスクに紐づくフォルダが存在しない場合は404エラー
    if (!$task->folder) {
        abort(404);
    }

    // タスクに紐づくフォルダが現在のユーザーに属していない場合は403エラー
    if ($task->folder->user_id !== auth()->id()) {
        abort(403);
    }

    // リクエストされたフォルダIDとタスクに紐づいているフォルダIDが一致しない場合は404エラー
    if ($id !== $task->folder_id) {
        abort(404);
    }

    return view('tasks/edit', [
        'task' => $task,
    ]);
    }

    public function edit(int $id, int $task_id, EditTask $request)
    {
        // 1 Taskモデルの検索
        $task = Task::find($task_id);

        // 2  リクエストデータに基づいてTaskモデルを更新
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        // 3 更新後は該当のタスク一覧へリダイレクト
        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}
