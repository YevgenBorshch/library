<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CORS
{
    /**
     * @var bool
     */
    private $allowCredentials;
    /**
     * @var int
     */
    private $maxAge;
    /**
     * @var string[]
     */
    private $exposeHeaders;
    /**
     * @var string[]
     */
    private $headers  = [
        'origin' => 'Access-Control-Allow-Origin',
        'Access-Control-Request-Headers' => 'Access-Control-Allow-Headers',
        'Access-Control-Request-Method' => 'Access-Control-Allow-Methods'
    ];
    /**
     * @var string[]
     */
    private $allowOrigins;

    public function __construct()
    {
        $this->allowCredentials = true;
        // время для кеширования пред-запросов
        $this->maxAge = 600;
        // разрешенные заголовки
        $this->exposeHeaders = [];
        // разрешенные хосты для обращения
        $this->allowOrigins = [];
    }

    public function handle(Request $request, Closure $next)
    {
        // проверка разрешения на обращение данного клиента
        if (
            !empty($this->allowOrigins)
            && $request->hasHeader('origin')
            && !in_array($request->header('origin'), $this->allowOrigins)
        ) {
            return new JsonResponse("origin: {$request->header('origin')} not allowed");
        }

        // пред-запрос
        if ($request->hasHeader('origin') && $request->isMethod('OPTIONS')) {
            $response = new JsonResponse('cors pre response');
        } else {
            $response = $next($request);
        }

        // добавление заголовков в ответ
        foreach ($this->headers as $key => $value) {
            if ($request->hasHeader($key)) {
                $response->header($value, $request->header($key));
            }
        }

        // "обязательные" заголовки
        $response->header('Access-Control-Max-Age', $this->maxAge);
        $response->header('Access-Control-Allow-Credentials', $this->allowCredentials);
        $response->header('Access-Control-Expose-Headers', implode(', ', $this->exposeHeaders));

        return $response;
    }
}
