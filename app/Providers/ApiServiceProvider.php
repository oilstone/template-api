<?php

namespace App\Providers;

use Api\Api;
use Api\Config\Manager;
use Api\Config\Store;
use Api\Package;
use Api\Repositories\Contracts\User as UserRepositoryInterface;
use App\Exceptions\Handlers\FormatAnyException;
use App\Exceptions\Handlers\FormatAuthException;
use App\Exceptions\Handlers\FormatNotFoundException;
use App\Exceptions\Handlers\FormatValidationException;
use App\Exceptions\Handlers\LogException;
use App\Factories\Schema as SchemaFactory;
use App\Repositories\User;
use Illuminate\Support\ServiceProvider;
use Oilstone\ApiResourceLoader\ApiResourceLoader;
use Stitch\DBAL\Connection;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $package = new Package();

        $package->configure('request', function (Store $config) {
            if (in_array(request()->segment(1), config('app.available_locales'))) {
                $config->set('prefix', request()->segment(1));
            }
        });

        $this->registerOAuth($package);

        $this->registerConnections();

        $this->app->singleton(Api::class, function () use ($package) {
            $api = $package->api();

            $this->registerExceptionHandlers($api);

            $this->registerResources($api);

            return $api;
        });
    }

    /**
     * @param Package $package
     * @return void
     */
    protected function registerOAuth(Package $package): void
    {
        $package->bind(UserRepositoryInterface::class, User::class);

        $package->configure('guard', function (Manager $config) {
            /** @noinspection PhpUndefinedMethodInspection */
            $config->use('OAuth2')
                ->publicKeyPath(config('api.oauth.keys.public'))
                ->privateKeyPath(config('api.oauth.keys.private'))
                ->encryptionKey(config('api.oauth.keys.encryption'))
                ->grants(['client_credentials', 'password', 'refresh_token']);
        });
    }

    /**
     * @return void
     */
    protected function registerConnections(): void
    {
        Package::addConnection(function (Connection $connection) {
            $connection->host(config('database.connections.mysql.host'))
                ->database(config('database.connections.mysql.database'))
                ->username(config('database.connections.mysql.username'))
                ->password(config('database.connections.mysql.password'));
        });
    }

    /**
     * @param Api $api
     * @return void
     */
    protected function registerExceptionHandlers(Api $api): void
    {
        $api->exceptionHandler(app(LogException::class));
        $api->exceptionHandler(app(FormatNotFoundException::class));
        $api->exceptionHandler(app(FormatAuthException::class));
        $api->exceptionHandler(app(FormatValidationException::class));
        $api->exceptionHandler(app(FormatAnyException::class));
    }

    /**
     * @param Api $api
     * @return void
     */
    protected function registerResources(Api $api): void
    {
        ApiResourceLoader::make()
            ->api($api)
            ->loadResourcesFromPath(base_path('app/Resources/*.php'), '\\App\\Resources\\');
    }
}
