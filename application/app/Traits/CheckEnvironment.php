<?php


namespace App\Traits;


use Illuminate\Support\Facades\App;

trait CheckEnvironment
{
    /**
     * Filter error message for prod environment
     * @param string $message
     * @return string
     */
    public static function filterErrorMessage(string $message): string
    {
        return (App::environment() !== 'prod') ? $message : 'An internal error. Please look log file';
    }
}
