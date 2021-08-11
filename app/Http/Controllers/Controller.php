<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @return View
     */
    public function home(): View
    {
        return view('welcome');
    }
}
