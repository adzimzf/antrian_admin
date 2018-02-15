<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 14/02/18
 * Time: 22:39
 */

namespace App\Http\Middleware;


use App\Http\Libraries\Helper;
use Closure;
use \Firebase\JWT\JWT;
use App\Models\Customers;

class ApiAuth
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $pieces = explode(" ", $request->header('AUTHORIZATION'));
        $cus    = Customers::where(["auth_token"=>$pieces[1], "is_login"=>1])->first();

        if (count($pieces) > 1){
            if (!empty($pieces[1])){
                if ($pieces[0] == "ADZIM" && $cus) {
                   try {
                        $credentials = JWT::decode($pieces[1], env('SECRET_KEY'), ['HS256']);
                        return $next($request);
                    } catch(ExpiredException $e) {
                        Helper::response(false, "Token expired", null);
                    } catch(Exception $e) {
                        Helper::response(false, "Error decoding token", null);
                    }
                }
            }
        }

        Helper::response(false, "Worng token", null);

    }

}
