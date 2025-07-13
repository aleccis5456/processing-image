<?php

namespace App\Providers;

use App\Support\CleanupImages;
use Illuminate\Support\Facades\Artisan;
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
        // Artisan::after(function($command, $input, $status){
        //     if($command == 'migrate:fresh'){
        //         CleanupImages::cleanup();
        //         info('Cleanup Images Completed');
        //     }
        // });
    }
}
