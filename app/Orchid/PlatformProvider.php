<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Illuminate\Support\Facades\Route;

use App\Orchid\Screens\Post\PostListScreen;
use App\Orchid\Screens\Post\PostEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserEditScreen;

class PlatformProvider extends OrchidServiceProvider
{
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // === ГЛАВНЫЙ МАРШРУТ ===
        Route::screen('main', PostListScreen::class)
            ->name('platform.main');
        
        // === ПУБЛИКАЦИИ ===
        Route::screen('posts', PostListScreen::class)
            ->name('platform.posts');
            
        Route::screen('posts/create', PostEditScreen::class)
            ->name('platform.post.create');
            
        Route::screen('posts/{post}/edit', PostEditScreen::class)
            ->name('platform.post.edit');
        
        // === ПОЛЬЗОВАТЕЛИ ===
        Route::screen('users', UserListScreen::class)
            ->name('platform.users');
            
        Route::screen('users/create', UserEditScreen::class)
            ->name('platform.user.create');
            
        Route::screen('users/{user}/edit', UserEditScreen::class)
            ->name('platform.user.edit');
    }

    public function menu(): array
    {
        return [
            Menu::make('Публикации')
                ->icon('bs.file-text')
                ->route('platform.posts')
                ->title('Контент'),

            Menu::make('Пользователи')
                ->icon('bs.people')
                ->route('platform.users')
                ->title('Система'),
        ];
    }

    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}