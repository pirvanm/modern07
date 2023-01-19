<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use App\Http\Services\GridDataService;
use App\Utils\TelerikDataSourceResult;
use Modules\Partners\Entities\Partner;
use Illuminate\Support\ServiceProvider;
use Modules\Employee\Entities\Employee;
use Modules\Proposals\Entities\Proposal;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TelerikDataSourceResult::class, function ($app) {
            try {
                $dbConfig = DB::connection()->getConfig();
                $connectionString = sprintf(
                    "mysql:dbname=%s;host=%s;port=%s",
                    $dbConfig['database'],
                    $dbConfig['host'],
                    $dbConfig['port']
                );
                $pdo = new \PDO($connectionString, $dbConfig['username'], $dbConfig['password'], []);
                return new TelerikDataSourceResult($pdo);
            } catch (\Exception $e) {
            }
        });


        $this->app->singleton(GridDataService::class, function ($app) {
            try {
                return new GridDataService($this->app->make(TelerikDataSourceResult::class));
            } catch (\Exception $e) {
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'Partner' => Partner::class
        ]);
        Relation::morphMap([
            'Employee' => Employee::class
        ]);

        Relation::morphMap([
            'Proposal' => Proposal::class
        ]);
    }
}
