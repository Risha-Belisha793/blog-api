<?php

namespace App\Orchid\Screens\User;

use App\Models\User;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use App\Orchid\Layouts\User\UserTableLayout;

class UserListScreen extends Screen
{
    public $name = 'Пользователи';
    public $description = 'Управление пользователями системы';

    public function query(): iterable
    {
        return [
            'users' => User::latest()->paginate(10),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Создать пользователя')
                ->route('platform.user.create')
                ->icon('plus'),
        ];
    }

    public function layout(): iterable
    {
        return [
            new UserTableLayout(),
        ];
    }
}