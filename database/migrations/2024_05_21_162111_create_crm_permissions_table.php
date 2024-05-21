<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('crm_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name')->unique();
            $table->string('description');

            $table->timestamps();
        });

        // вносим начальные значения
        $this->inserDefaultRows();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_permissions');
    }

    private function inserDefaultRows(): void
    {
        DB::table('crm_permissions')->insert([
            [
                'name' => 'full_access',
                'display_name' => 'Полный доступ',
                'description' => 'весь возможный функционал системы',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'manage_requests',
                'display_name' => 'Внос и работа с заявками',
                'description' => 'можно вносить заявки в систему (возможно без маршрутизации), если без маршрута, то планирование по Ганту с учетом настроек по операц. времени и исполнит чистая CRM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'routing',
                'display_name' => 'Маршрутизация',
                'description' => 'работа алгоритма оптимизации маршрута по заданным ограничениям, может работать со встроенной CRM, так и при загрузке пользовательских данных в виде таблиц',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'mobile_app',
                'display_name' => 'Мобильное приложение',
                'description' => 'допуск к работе с мобильным приложением',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'data_upload',
                'display_name' => 'Загрузка данных в CRM',
                'description' => 'разрешена загрузка базы данных в CRM систему пользователя',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'schedule_upload',
                'display_name' => 'Загрузка расписания',
                'description' => 'загрузка готового расписания для работы с приложением и/или для предварительной оптимизации в маршрутизаторе',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'report_arshin',
                'display_name' => 'Отчёт для Аршин',
                'description' => 'активация (появление) кнопки в приложении "внести в Аршин"',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
};
