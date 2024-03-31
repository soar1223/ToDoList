<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToFolders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('folders', function (Blueprint $table) {
            // 符号なしの整数としてuser_idを追加
            $table->unsignedBigInteger('user_id');

            // 外部キーを設定する
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('folders', function (Blueprint $table) {
            // 外部キー制約を削除
            $table->dropForeign(['user_id']);
            
            // user_idカラムを削除
            $table->dropColumn('user_id');
        });
    }
}
