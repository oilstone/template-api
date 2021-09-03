<?php

namespace App\Resources;

use Api\Schema\Stitch\Schema;
use Closure;
use Oilstone\ApiResourceLoader\Resources\Stitch;
use Stitch\DBAL\Schema\Table;

class User extends Stitch
{
    /**
     * @var string|null
     */
    protected ?string $repository = \App\Repositories\User::class;
    /**
     * @var string[]
     */
    protected array $belongsTo = [
        'user-role',
    ];

    /**
     * @param Schema $schema
     * @return void
     */
    public function schema(Schema $schema): void
    {
        $schema->getProperty('id')->sometimes();
        $schema->getProperty('user_role_id')->required();
        $schema->getProperty('email')->required()->email();
        $schema->getProperty('email_confirmed')->sometimes();
        $schema->getProperty('password')->sometimes();
        $schema->getProperty('first_name')->required();
        $schema->getProperty('last_name')->required();
        $schema->getProperty('is_admin')->sometimes();
    }

    /**
     * @param Table $table
     * @return void
     * @noinspection PhpUndefinedMethodInspection
     */
    public function model(Table $table): void
    {
        $table->name('users');
        $table->integer('id')->increments()->primary();
        $table->integer('user_role_id')->references('id')->on('user_roles');
        $table->string('email');
        $table->boolean('email_confirmed');
        $table->string('password');
        $table->string('first_name');
        $table->string('last_name');
        $table->boolean('is_admin');
    }

    /**
     * @return Closure
     */
    public function belongsToUserRole(): Closure
    {
        return function ($relation) {
            $relation->bind('user-roles');
        };
    }
}
