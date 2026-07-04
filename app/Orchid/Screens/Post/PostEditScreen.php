<?php

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;

class PostEditScreen extends Screen
{
    public $name = 'Редактирование публикации';
    public $description = 'Создание или редактирование публикации';

    public function query(?Post $post): iterable
    {
        $post->load('user');

        return [
            'post' => $post,
            'users' => User::pluck('name', 'id'),
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
                ->confirm('Вы уверены, что хотите удалить эту публикацию?'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                \Orchid\Screen\Fields\Input::make('post.title')
                    ->type('text')
                    ->required()
                    ->title('Заголовок')
                    ->placeholder('Введите заголовок публикации'),

                \Orchid\Screen\Fields\Select::make('post.user_id')
                    ->fromModel(User::class, 'name')
                    ->title('Автор')
                    ->required(),

                \Orchid\Screen\Fields\TextArea::make('post.content')
                    ->required()
                    ->title('Содержание')
                    ->rows(10)
                    ->placeholder('Введите текст публикации'),
            ]),
        ];
    }

    public function save(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'post.title' => 'required|string|max:255',
            'post.user_id' => 'required|exists:users,id',
            'post.content' => 'required|string',
        ]);

        Post::updateOrCreate(
            ['id' => $request->route('post')],
            $data['post']
        );

        Alert::info('Публикация сохранена!');

        return redirect()->route('platform.post.list');
    }

    public function delete(Request $request): \Illuminate\Http\RedirectResponse
    {
        Post::findOrFail($request->route('post'))->delete();

        Alert::info('Публикация удалена!');

        return redirect()->route('platform.post.list');
    }
}