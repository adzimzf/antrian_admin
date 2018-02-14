<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 11/02/18
 * Time: 23:04
 */

namespace App\Http\Middleware;

use Closure;

class Designer
{

    public function handle($request, Closure $next) {
        if (auth()->check() && in_array($request->user()->role_id,['1', '4'] )) {
            return $next($request);
        }

        return redirect('/');
    }
}
