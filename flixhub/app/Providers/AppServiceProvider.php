<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Força o PHP de dentro do container a aceitar arquivos de até 100MB
        @ini_set('upload_max_filesize', '100M');
        @ini_set('post_max_size', '100M');
    }
}
