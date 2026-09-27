<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        View::composer(['layouts.main', 'home'], function ($view) {
            // Если контроллер уже передал parentCategories — не перезаписываем
            if (array_key_exists('parentCategories', $view->getData())) {
                return;
            }

            if (Schema::hasTable('categories')) {
                $parentCategories = Category::query()
                    ->whereNull('parent_id')
                    ->where('active', true)
                    ->with('children')
                    ->get();
            } else {
                $parentCategories = collect();
            }

            $view->with('parentCategories', $parentCategories);
        });
    }
}
