<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomLogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Clear all session data from the server
        $request->session()->flush();

        // Clear the session cookie from the client-side
        $cookie = cookie('laravel_session', null, -1);

        $response = redirect(RouteServiceProvider::HOME)->withCookie($cookie);

        $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');

        return $response;
    }
}
