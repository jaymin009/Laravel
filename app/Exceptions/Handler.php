<?php

namespace App\Exceptions;

use Exception;
use Flinnt\Core\Exceptions\Presenters\ExceptionToJsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class Handler
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		AuthenticationException::class,
		AuthorizationException::class,
		HttpException::class,
		ModelNotFoundException::class,
		TokenMismatchException::class,
		ValidationException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception $exception
	 *
	 * @return void
	 */
	public function report( Exception $exception ) {
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception               $exception
	 *
	 * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
	 */
	public function render( $request, Exception $exception ) {
		// Based on request send the response
		if ( $request->expectsJson() ) {
			$response = new ExceptionToJsonResponse($exception);

			return $response->renderResponse();
		}

		return parent::render($request, $exception);
	}

	/**
	 * Convert an authentication exception into an unauthenticated response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function unauthenticated( $request ) {
		if ( $request->expectsJson() ) {
			return response()->json(['error' => trans('shared::message.error.unauthenticated')], 401);
		}

		return redirect()->guest(route('login'));
	}
}
