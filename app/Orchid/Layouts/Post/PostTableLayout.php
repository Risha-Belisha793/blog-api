<?php

namespace App\Orchid\Layouts\Post;

use App\Models\Post;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class PostTableLayout extends Table
{
    public $target = 'posts';

    public function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->cantHide()
                ->render(fn (Post $post) => $post->id), 

            TD::make('title', 'Заголовок')
                ->sort()
                ->render(fn (Post $post) => $post->title),

            TD::make('user.name', 'Автор')
                ->sort()
                ->render(fn (Post $post) => $post->user->name ?? 'Неизвестно'),

            TD::make('created_at', 'Дата создания')
                ->render(function (Post $post) {
                    $date = $post->created_at;

                    if (! $date instanceof \Carbon\CarbonInterface) {
                        return '<span class="text-muted">—</span>';
                    }

                    return sprintf(
                        '<div><strong>%s</strong></div><div class="text-muted small">%s</div>',
                        $date->format('d.m.Y'),
                        $date->format('H:i')
                    );
                })
                ->sort(),

            TD::make('Действия')
                ->cantHide()
                ->render(fn (Post $post) => Link::make('Редактировать')
                    ->route('platform.post.edit', $post->id)
                    ->icon('pencil')),
        ];
    }
}