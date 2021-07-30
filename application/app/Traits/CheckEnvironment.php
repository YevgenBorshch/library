<?php


namespace App\Traits;


use Illuminate\Support\Facades\App;

trait CheckEnvironment
{
    /**
     * Filter error message for prod environment
     * @param string $class
     * @param string $line
     * @param string $context
     * @return string
     */
    public static function filterErrorMessage(string $class, string $line, string $context): string
    {
        if (App::environment() !== 'prod') {
            return 'Class: ' . $class . '; Line: ' . $line . '; ' . __('api.arguments.bad') . '; Context: ' . $context;
        }

        return 'An internal error. Please look log file';
    }
}
