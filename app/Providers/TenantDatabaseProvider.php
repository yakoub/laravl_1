<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;

class TenantDatabaseProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
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
