<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Redirect;
use Osiset\ShopifyApp\Exceptions\MissingShopDomainException;
use Exception;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function(Exception $e, $request) {
            return $this->handleException($request, $e);
        });
    }

    public function handleException($request, Exception $exception)
    {
        if ($exception instanceof MissingShopDomainException) {
            return Redirect::secure('login');
        }
    }
}
