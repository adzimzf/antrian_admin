<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 12/02/18
 * Time: 23:30
 */

namespace App\Http\Middleware;


use Closure;

class MyAuth
{

    public function handle($request, Closure $next) {
        if (auth()->check()) {
            return $next($request);
        }

        return redirect('/');
    }
}
