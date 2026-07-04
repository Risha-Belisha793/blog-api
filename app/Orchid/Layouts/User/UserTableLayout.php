<?php

namespace App\Orchid\Layouts\User;

use App\Models\User;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Components\Cells\DateTimeSplit;

class UserTableLayout extends Table
{
    public $target = 'users';

    public function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->cantHide(),

            TD::make('name', 'Имя')
                ->sort()
                ->render(fn (User $user) => $user->name),

            TD::make('email', 'Email')
                ->sort()
                ->render(fn (User $user) => $user->email),

            TD::make('created_at', 'Дата регистрации')
                ->usingComponent(DateTimeSplit::class)
                ->sort(),

            TD::make('Действия')
                ->cantHide()
                ->render(fn (User $user) => Link::make('Редактировать')
                    ->route('platform.user.edit', $user->id)
                    ->icon('pencil')),
        ];
    }
}