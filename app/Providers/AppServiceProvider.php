<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        $settings = Setting::checkSettings();
        $categories = Category::with('children')->where('parent' , 0)->orWhere('parent' , null)->get();
        $lastFivePosts = Post::with('category','user')->orderBy('id')->limit(5)->get();
        View()->share([
            'setting'=>$settings,
            'categories'=>$categories,
            'lastFivePosts'=>$lastFivePosts,
        ]);
    }
}
