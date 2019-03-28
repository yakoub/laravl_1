<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use App\Util\Greeting;
use App\Positive\PositiveGreeting;

class TenantDatabaseProvider extends ServiceProvider
{
    /*public $bindings = [
        Greeting::class => PositiveGreeting::class
    ];*/

    public function register() {
        $this->app->bind(
            'App\Util\Lingual',
            'App\Positive\PositiveGreeting'
            //'App\Util\Greeting'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(DatabaseManager $db_manager, Request $request)
    {
        if ($request->filled('db2')) {
            $db_manager->setDefaultConnection('mysql_db2');
        }
    }
}
