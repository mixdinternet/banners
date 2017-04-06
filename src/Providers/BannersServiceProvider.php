<?php

namespace Mixdinternet\Banners\Providers;

use Illuminate\Support\ServiceProvider;
use Mixdinternet\Banners\Banner;
use Menu;

class BannersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setMenu();

        $this->setRoutes();

        $this->loadViews();

        $this->loadMigrations();

        $this->publish();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/maudit.php', 'maudit.alias');

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Banner', 'Mixdinternet\Banners\Facades\BannersFacade');
    }

    protected function setMenu()
    {
        Menu::modify('adminlte-sidebar', function ($menu) {
            $menu->route('admin.banners.index', config('mbanners.name', 'Banners'), [], config('mbanners.order', 30)
                , ['icon' => config('mbanners.icon', 'fa fa-image'), 'active' => function () {
                    return checkActive(route('admin.banners.index'));
                }])->hideWhen(function () {
                return checkRule('admin.banners.index');
            });
        });

        Menu::modify('adminlte-permissions', function ($menu) {
            $menu->url('admin.banners', config('mbanners.name', 'Banners'), config('mbanners.order', 30));
        });
    }

    protected function setRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $this->app->router->group(['namespace' => 'Mixdinternet\Banners\Http\Controllers'],
                function () {
                    require __DIR__ . '/../routes/web.php';
                });
        }
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mixdinternet/banners');
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/mixdinternet/banners'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../database/migrations' => base_path('database/migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../config/mbanners.php' => base_path('config/mbanners.php'),
        ], 'config');
    }
}
