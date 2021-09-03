<?php

namespace App\Resources;

use Api\Schema\Stitch\Schema;
use Closure;
use Oilstone\ApiResourceLoader\Resources\Stitch;
use Stitch\DBAL\Schema\Table;

class PageModules extends Stitch
{
    /**
     * @var string[]
     */
    protected array $belongsTo = [
        'page',
        'module',
    ];

    /**
     * @param Schema $schema
     * @return void
     */
    public function schema(Schema $schema): void
    {
        $schema->getProperty('id')->sometimes();
        $schema->getProperty('module_id')->required();
        $schema->getProperty('page_id')->required();
    }

    /**
     * @param Table $table
     * @return void
     * @noinspection PhpUndefinedMethodInspection
     */
    public function model(Table $table): void
    {
        $table->name('module_page');
        $table->integer('id')->increments()->primary();
        $table->integer('module_id')->references('id')->on('modules');
        $table->integer('page_id')->references('id')->on('pages');
    }

    /**
     * @return Closure
     */
    public function belongsToPage(): Closure
    {
        return function ($relation) {
            $relation->bind('pages');
        };
    }

    /**
     * @return Closure
     */
    public function belongsToModule(): Closure
    {
        return function ($relation) {
            $relation->bind('modules');
        };
    }
}
