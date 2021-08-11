<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;
use Oilstone\SystemStatus\SystemStatus;
use Throwable;

class Monitor extends BaseController
{
    /**
     * @return Response
     * @noinspection PhpUnusedLocalVariableInspection
     */
    public function ping(): Response
    {
        try {
            if (SystemStatus::isSystemOkay(['deployment', 'connections'])) {
                return response('OK');
            }
        } catch (Throwable $t) {
            //
        }

        return response('ERROR', 500);
    }

    /**
     * @return Response
     * @noinspection PhpUnusedLocalVariableInspection
     */
    public function status(): Response
    {
        try {
            dump(SystemStatus::scores());

            $errors = SystemStatus::errors();

            if ($errors) {
                echo '<hr><h2>Errors:</h2>';

                dump(SystemStatus::errors());
            }

            exit();
        } catch (Throwable $t) {
            return response('Invalid monitor configuration', 500);
        }
    }

    /**
     * @return Response
     * @noinspection PhpUnused
     */
    public function heartbeat(): Response
    {
        return response('OK');
    }
}
