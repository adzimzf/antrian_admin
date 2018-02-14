<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 14/02/18
 * Time: 22:39
 */

namespace App\Http\Middleware;


use App\User;
use Closure;
use Illuminate\Http\Response;

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

        if (count($pieces) > 1){
            $query = User::where("auth_token", "=", $pieces[1]);
            $token = $query->first();
            if (!empty($pieces[1])){
                if ($pieces[0] == "ADZIM" && !is_null($token)) {
//                    if ($token->auth_expiry > date("Y-m-d H:s:i")){
                    //update auth expr
                    return $next($request);
                }
            }
        }

        return $this->sendError();

    }

    /**
     * Send error response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function sendError($messages = 'Wrong Token')
    {
        $return["error"] = true;
        $return["message"] = $messages;
        $return['data'] = null;
        return response()->json($return);
    }

}
