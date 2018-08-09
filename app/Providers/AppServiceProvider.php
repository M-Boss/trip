<?php

namespace App\Providers;

use App\Repositories\Requests\Requests;
use App\Repositories\Requests\RequestsDatabase;
use App\Repositories\Users\Users;
use App\Repositories\Users\UsersDatabase;
use App\Services\ShortMessage\ShortMessage;
use App\Services\ShortMessage\ShortMessageFile;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Requests::class, RequestsDatabase::class);
        $this->app->singleton(Users::class, UsersDatabase::class);
        $this->app->singleton(ShortMessage::class, ShortMessageFile::class);
    }
}
