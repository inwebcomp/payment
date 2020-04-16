<?php

namespace InWeb\Payment;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    protected static $packagePath = __DIR__ . '/../../';
    protected static $packageAlias = 'payment';

    public static function getPackageAlias()
    {
        return self::$packageAlias;
    }

    public static function getPackagePath()
    {
        return self::$packagePath;
    }

    /**
     * Bootstrap any package services.
     *
     * @param Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        \App::bind('payment', function () {
            return new Drivers\Paynet\Paynet();
        });

        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerResources();
    }

    /**
     * Register the package resources such as routes, templates, etc.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadMigrationsFrom(self::$packagePath . 'src/database/migrations');

        if ($this->app->runningInConsole()) {
            $this->app->make(EloquentFactory::class)->load(self::$packagePath . 'src/database/factories');
        }
    }

    private function registerPublishing()
    {
        // Config
        $this->publishes([
            self::$packagePath . 'config/config.php' => config_path(self::$packageAlias . '.php'),
        ], 'config');
    }
}
