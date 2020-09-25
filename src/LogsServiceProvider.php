<?php

namespace Dcat\Admin\Extension\Logs;

use Illuminate\Support\ServiceProvider;

class LogsServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $extension = Logs::make();

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, Logs::NAME);
        }

        if ($lang = $extension->lang()) {
            $this->loadTranslationsFrom($lang, Logs::NAME);
        }

        if ($migrations = $extension->migrations()) {
            $this->loadMigrationsFrom($migrations);
        }

        $this->app->booted(function () use ($extension) {
            $extension->routes(__DIR__.'/../routes/web.php');
        });

        // $this->registerMenus();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
