<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Task; // Task モデルを使用
use Carbon\Carbon;

class TasksTableSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 3) as $num) {
            Task::create([
                'folder_id' => 1,
                'title' => "サンプルタスク {$num}",
                'status' => $num,
                'due_date' => Carbon::now()->addDay($num),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
