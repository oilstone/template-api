<?php

namespace App\Exceptions;

use App\Exceptions\Handlers\FormatAnyException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Neomerx\JsonApi\Contracts\Schema\DocumentInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e) {
            $parser = new FormatAnyException;

            return response()->json([
                'errors' => [
                    array_filter([
                        DocumentInterface::KEYWORD_ERRORS_ID => $parser->getId($e),
                        DocumentInterface::KEYWORD_ERRORS_CODE => $parser->getCode($e),
                        DocumentInterface::KEYWORD_ERRORS_STATUS => $parser->getStatus($e),
                        DocumentInterface::KEYWORD_ERRORS_TITLE => $parser->getTitle($e),
                        DocumentInterface::KEYWORD_ERRORS_DETAIL => $parser->getDetail($e),
                        DocumentInterface::KEYWORD_ERRORS_META => $parser->getMeta($e),
                    ]),
                ],
            ], $parser->getStatus($e));
        });
    }
}
