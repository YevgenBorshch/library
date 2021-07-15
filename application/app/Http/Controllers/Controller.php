<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Filter error message for prod environment
     * @param string $message
     * @return string
     */
    protected function filterErrorMessage(string $message): string
    {
        return (App::environment() !== 'prod') ? $message : 'An internal error. Please look log file';
    }
}
