<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // increments の代わりに id メソッドを使用
            $table->foreignId('folder_id') // integer('folder_id')->unsigned() の代わりに foreignId を使用
                  ->constrained('folders') // 外部キーの制約を簡単に設定
                  ->onDelete('cascade'); // folders テーブルのレコードが削除されたときに、関連する tasks レコードも削除
            $table->string('title', 100);
            $table->date('due_date');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
