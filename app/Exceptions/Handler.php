<?php

namespace App\Exceptions;

use Illuminate\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * @param  Container  $container
     * @param  ResponseFactory  $response
     */
    public function __construct(Container $container, private ResponseFactory $response)
    {
        parent::__construct($container);
    }
    
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
            $response = $this->getApiResponse($exception, parent::render($request, $exception));
        } else {
            $response = parent::render($request, $exception);
        }

        return $response;
    }
    
    private function getApiResponse(Throwable $exception, JsonResponse|RedirectResponse|Response $response)
    {
        $debugEnabled = config('app.debug');
        $statusCode = $response->getStatusCode();
        $error['message'] = $response->original['message'];

        if (Response::HTTP_UNPROCESSABLE_ENTITY === $statusCode) {
            $error['errors'] = $response->original['errors'];
        }

        if (Response::HTTP_INTERNAL_SERVER_ERROR === $statusCode) {
            if ($debugEnabled) {
                $error['message'] = $response->original['message'];
            }
        }

        $data = [
            'success' => false,
            'data' => null,
            'error' => $error,
        ];

        if ($debugEnabled) {
            $debug['file'] = $exception->getFile();
            $debug['line'] = $exception->getLine();
            $debug['trace'] = $exception->getTrace();

            $data['debug'] = $debug;
        }

        return $this->response->json($data, $statusCode);
    }
}
