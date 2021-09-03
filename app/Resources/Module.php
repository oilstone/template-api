<?php

namespace App\Resources;

use Api\Schema\Stitch\Schema;
use Closure;
use Oilstone\ApiResourceLoader\Resources\Stitch;
use Stitch\DBAL\Schema\Table;

class Module extends Stitch
{
    /**
     * @var string[]
     */
    protected array $belongsTo = [
        'parent',
    ];

    /**
     * @var string[]
     */
    protected array $hasMany = [
        'modules',
        'page-modules',
    ];

    /**
     * @param Schema $schema
     * @return void
     */
    public function schema(Schema $schema): void
    {
        $schema->getProperty('id')->sometimes();
        $schema->getProperty('parent_id')->sometimes()->nullable();
        $schema->getProperty('position')->sometimes()->nullable();
        $schema->getProperty('sort')->sometimes()->nullable();
        $schema->getProperty('type')->required();
        $schema->getProperty('title')->sometimes()->nullable();
        $schema->getProperty('attributes')->sometimes()->nullable();
    }

    /**
     * @param Table $table
     * @return void
     * @noinspection PhpUndefinedMethodInspection
     */
    public function model(Table $table): void
    {
        $table->name('modules');
        $table->integer('id')->increments()->primary();
        $table->integer('parent_id')->references('id')->on('modules');
        $table->string('position');
        $table->integer('sort');
        $table->string('type');
        $table->string('title');
        $table->string('attributes');
    }

    /**
     * @return Closure
     */
    public function belongsToParent(): Closure
    {
        return function ($relation) {
            $relation->bind('modules');
        };
    }
}
