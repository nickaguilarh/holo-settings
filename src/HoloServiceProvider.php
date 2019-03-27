<?php

namespace Holo;

use Illuminate\Support\ServiceProvider;

class HoloServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
        $this->registerCommands();

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrationCommand::class,
            ]);
        }
    }

    public function publishConfig(){
        $this->publishes([
            __DIR__ . '/../config/holo.php' => config_path('holo.php'),
        ], 'config');
    }


    /**
     * Get the services provided.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.Holo.migration'
        ];
    }
}
