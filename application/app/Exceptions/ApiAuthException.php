<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ApiAuthException extends Exception
{
    /**
     * @var string
     */
    protected $message;

    /**
     * ApiAuthException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct();
        $this->message = $message;
    }


    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report(): ?bool
    {
        Log::error('customError', [$this->message]);
        return true;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  Request  $request
     * @return Response
     */
    public function render(Request $request): Response
    {
        return response(['code' => 500, 'message' => $this->message]);
    }
}
