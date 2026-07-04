<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Orchid\Platform\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем роль администратора
        $adminRole = Role::query()->firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrator',
                'permissions' => [
                    'platform.index' => true,
                    'platform.systems' => true,
                    'platform.systems.roles' => true,
                    'platform.systems.users' => true,
                ],
            ]
        );

        // Создаем пользователя-администратора
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Добавляем роль пользователю
        $admin->addRole($adminRole);

        $this->command->info('✅ Администратор создан!');
        $this->command->info('Email: admin@admin.com');
        $this->command->info('Пароль: password');
    }
}