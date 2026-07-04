<?php

namespace App\Orchid\Screens\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;

class UserEditScreen extends Screen
{
    public $name = 'Редактирование пользователя';
    public $description = 'Создание или редактирование пользователя';

    public function query(?User $user): iterable
    {
        return [
            'user' => $user,
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('save'),

            Button::make('Удалить')
                ->icon('trash')
                ->method('delete')
                ->confirm('Вы уверены, что хотите удалить этого пользователя?'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                \Orchid\Screen\Fields\Input::make('user.name')
                    ->type('text')
                    ->required()
                    ->title('Имя')
                    ->placeholder('Введите имя пользователя'),

                \Orchid\Screen\Fields\Input::make('user.email')
                    ->type('email')
                    ->required()
                    ->title('Email')
                    ->placeholder('Введите email'),

                \Orchid\Screen\Fields\Password::make('user.password')
                    ->title('Пароль')
                    ->placeholder('Оставьте пустым, если не хотите менять'),
            ]),
        ];
    }

    public function save(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email|unique:users,email,' . $request->route('user'),
            'user.password' => 'nullable|string|min:6',
        ]);

        $userData = $data['user'];

        if (empty($userData['password'])) {
            unset($userData['password']);
        } else {
            $userData['password'] = Hash::make($userData['password']);
        }

        User::updateOrCreate(
            ['id' => $request->route('user')],
            $userData
        );

        Alert::info('Пользователь сохранён!');

        return redirect()->route('platform.user.list');
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        User::findOrFail($request->route('user'))->delete();

        Alert::info('Пользователь удалён!');

        return redirect()->route('platform.user.list');
    }
}