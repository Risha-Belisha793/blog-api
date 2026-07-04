<?php

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use App\Orchid\Layouts\Post\PostTableLayout;

class PostListScreen extends Screen
{
    public $name = 'Публикации';
    public $description = 'Управление публикациями блога';

    public function query(): iterable
    {
        return [
            'posts' => Post::with('user')->latest()->paginate(10),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Создать публикацию')
                ->route('platform.post.create')
                ->icon('plus'),
        ];
    }

    public function layout(): iterable
    {
        return [
            new PostTableLayout(),
        ];
    }
}