<?php

namespace App\Resources;

use Api\Schema\Stitch\Schema;
use App\Listeners\ApplyLanguageScope;
use App\Listeners\GenerateSlug;
use App\Listeners\HandlePublication;
use App\Listeners\HandlePublicationDate;
use Closure;
use Oilstone\ApiResourceLoader\Resources\Stitch;
use Stitch\DBAL\Schema\Table;

class Page extends Stitch
{
    /**
     * @var bool
     */
    protected bool $softDeletes = true;

    /**
     * @var string[]|Closure[]
     */
    protected array $modelListeners = [
        ApplyLanguageScope::class,
        HandlePublication::class,
        HandlePublicationDate::class,
        GenerateSlug::class,
    ];

    /**
     * @var string[]
     */
    protected array $hasMany = [
        'page-modules',
    ];

    /**
     * @param Schema $schema
     * @return void
     */
    public function schema(Schema $schema): void
    {
        $schema->getProperty('id')->sometimes();
        $schema->getProperty('language')->sometimes()->nullable();
        $schema->getProperty('translates_id')->sometimes()->nullable();
        $schema->getProperty('is_published')->sometimes();
        $schema->getProperty('slug')->sometimes()->nullable();
        $schema->getProperty('title')->required();
        $schema->getProperty('publish_at')->sometimes()->nullable();
    }

    /**
     * @param Table $table
     * @return void
     * @noinspection PhpUndefinedMethodInspection
     */
    public function model(Table $table): void
    {
        $table->name('pages');
        $table->integer('id')->increments()->primary();
        $table->string('language');
        $table->integer('translates_id')->references('id')->on('pages');
        $table->boolean('is_published');
        $table->string('slug');
        $table->string('title');
        $table->timestamp('publish_at');
    }
}
