<?php

namespace App\Http\Controllers;

use Api\Schema\Schema;
use Api\Schema\Validation\Collection as CollectionValidator;
use Illuminate\Routing\Controller as BaseController;
use Psr\Http\Message\ServerRequestInterface;
use Api\Api;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Validation extends BaseController
{
    /**
     * @param Api $api
     * @return string|ResponseInterface
     * @throws Throwable
     */
    public function validate(Api $api): string|ResponseInterface
    {
        $request = $api->getKernel()->resolve(ServerRequestInterface::class);
        $data = $request->getParsedBody()['data']['attributes'] ?? [];

        return $api->try(function () use ($api, $data)
        {
            $this->resolveSchema(
                $api->resolve($data['type'])->getschema(),
                $data['attributes']
            )->validate($data['attributes']);

            return response([
                'successMessage' => 'The resource provided is valid'
            ], 200)->header('Content-Type', 'application/vnd.api+json;charset=utf-8');
        });
    }

    /**
     * @param Schema $schema
     * @param array $attributes
     * @return Schema
     */
    protected function resolveSchema(Schema $schema, array $attributes): Schema
    {
        foreach ($schema->getProperties() as $key => $property) {
            if (!array_key_exists($key, $attributes)) {
                $schema->removeProperty($key);
                continue;
            }

            $property = $schema->getProperty($key);
            $accepts = $property->getAccepts();

            if ($accepts instanceof Schema) {
                $nestedAttributes = $attributes[$key];

                if ($property->getValidator() instanceof CollectionValidator) {
                    $nestedAttributes = array_merge(...$nestedAttributes);
                }

                $this->resolveSchema(
                    $accepts,
                    $nestedAttributes
                );
            }
        }

        return $schema;
    }
}
