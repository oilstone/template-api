<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Oilstone\SystemStatus\StatusCode;
use Oilstone\SystemStatus\SystemStatus;

class SystemStatusServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        SystemStatus::addMonitor([
            'alias' => 'Deployment validation file check',
            'type' => 'file',
            'file_path' => base_path('.deployed'),
            'test_type' => 'exists',
        ], 'deployment');

        SystemStatus::addMonitor([
            'alias' => 'Redis cluster connection check',
            'type' => 'redis',
            'test_key' => 'redis-monitor-check',
            'manager' => app('cache'),
            'expectations' => [
                'response_within' => [
                    200 => StatusCode::ACCEPTABLE,
                ],
            ],
        ], 'connections');

        SystemStatus::addMonitor([
            'alias' => 'MySQL connection check',
            'type' => 'mysql',
            'host' => config('database.connections.mysql.host'),
            'user' => config('database.connections.mysql.username'),
            'password' => config('database.connections.mysql.password'),
            'database' => config('database.connections.mysql.database'),
            'table' => 'migrations',
            'expectations' => [
                'response_within' => [
                    200 => StatusCode::ACCEPTABLE,
                ],
            ],
        ], 'connections');
    }
}
