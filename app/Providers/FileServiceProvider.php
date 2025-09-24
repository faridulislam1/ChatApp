<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FileHandlerInterface;
use App\Services\FileHandler;

class FileServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind interface to concrete class
        $this->app->bind(FileHandlerInterface::class, FileHandler::class);
    }

    public function boot()
    {
        //
    }
}
