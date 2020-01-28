<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        $response = parent::render($request, $exception);

        if (Str::startsWith($request->path(), 'api/')) {
            $errorClass = (new \ReflectionClass($exception))->getShortName();
            $typeUrl = url('/docs/errors') . '#' . $errorClass;
            $typeName = str_replace('_', ' ', Str::title(Str::snake($errorClass)));
            $errors = null;
            if (property_exists($response, 'original')) {
                $errors = $response->original['errors'] ?? null;
            }
            return response()->json([
                'type' => $typeUrl,
                'title' => $typeName,
                'detail' => $exception->getMessage(),
                'status' => $response->getStatusCode(),
                'errors' => $errors,
            ], $response->getStatusCode());
        }

        return parent::render($request, $exception);
    }
}
