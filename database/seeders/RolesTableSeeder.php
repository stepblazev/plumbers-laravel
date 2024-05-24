<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'superadmin']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Суперадмин',
            ])->save();
        }
        
        $role = Role::firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Админ',
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'subadmin']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Админ 2-го порядка'
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'logist']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Логист'
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'operator']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Оператор'
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'agent']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Агент'
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'performer']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Исполнитель'
            ])->save();
        }
    }
}
