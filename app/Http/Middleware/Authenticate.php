<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Si la solicitud es OPTIONS, responder con un código 200 OK
        if ($request->isMethod('OPTIONS')) {
            return response()->json([], 200); // Responder con OK para OPTIONS
        }

        // Si la solicitud no espera JSON, devolver un error 401
        if (! $request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Si la solicitud es JSON y no está autenticada, devolver un error 401
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
