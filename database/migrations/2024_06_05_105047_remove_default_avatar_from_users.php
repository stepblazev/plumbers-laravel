<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDefaultAvatarFromUsers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->default(null)->change();
        });

        // обновляем существующие записи, чтобы убрать значение по умолчанию
        \DB::table('users')
            ->where('avatar', 'users/default.png')
            ->update(['avatar' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->default('users/default.png')->change();
        });

        // возвоащаем значение для тех, у кого avatar равен null
        \DB::table('users')
            ->whereNull('avatar')
            ->update(['avatar' => 'users/default.png']);
    }
}

