<?php

namespace JuniYadi\GitHub\Providers;

use Illuminate\Support\ServiceProvider;
use JuniYadi\GitHub\Github;

class GithubServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/github.php', 'github');

        $this->app->singleton('github-api', function ($app) {
            return new Github(config('github.token'));
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/github.php' => config_path('github.php'),
        ], 'config');
    }
}
