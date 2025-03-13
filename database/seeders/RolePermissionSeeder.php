<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // إنشاء الصلاحيات
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        // إنشاء الأدوار
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // إعطاء الصلاحيات للأدوار
        $adminRole->givePermissionTo(['view users', 'edit users', 'delete users']);
        $userRole->givePermissionTo('view users');

        // تعيين دور Admin لـ Test User
        $admin = \App\Models\User::where('email', 'test@example.com')->first();
        $admin->assignRole('admin');

        // تعيين دور User لـ user2
        $user = \App\Models\User::where('email', 'user2@example.com')->first();
        $user->assignRole('user');
    }
}