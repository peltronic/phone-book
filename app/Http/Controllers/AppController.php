<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class AppController extends Controller
{
    public function index(Request $request)
    {
        if ( $request->wantsJson() ) {
            abort(404, 'Route requesting JSON response');
        }

        return view('app');
        /*
        if ( Auth::user() ) {
            return view('app');
        }

        return view('guest');
         */
    }

}

