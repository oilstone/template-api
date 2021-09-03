<?php

namespace App\Resources;

use Api\Schema\Stitch\Schema;
use Oilstone\ApiResourceLoader\Resources\Stitch;

class UserRole extends Stitch
{
    /**
     * @var string[]
     */
    protected array $hasMany = [
        'users',
    ];

    /**
     * @param Schema $schema
     * @return void
     */
    public function schema(Schema $schema): void
    {
        $schema->getProperty('id')->sometimes();
        $schema->getProperty('lookup')->required();
        $schema->getProperty('title')->required();
    }
}
