<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        // Add any routes you want to exclude from CSRF protection
    ];

    public function handle($request, Closure $next): Response
    {
        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $e) {
            return response()->json(['message' => 'CSRF token mismatch'], 419);
        }
    }
}