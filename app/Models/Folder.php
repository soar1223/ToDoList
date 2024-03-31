<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task; 

class Folder extends Model
{
    use HasFactory;
    
    public function tasks()
    {
        // Laravel 8ではモデルのフルネームスペースを使用
        return $this->hasMany(Task::class);
    }
}
