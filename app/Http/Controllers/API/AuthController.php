<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 14/02/18
 * Time: 22:50
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Helper;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return "login";
    }

    public function register(Request $request)
    {
        Helper::validate($request, [
            "fullname"  => "required",
            "password"  => "required",
            "username"  => "required"
        ]);
        $fullname = $request->input("fullname");
        $password = $request->input("password");
        $username = $request->input("username");

        $jwt = $jwt = JWT::encode("adzim", "test");
        echo $jwt;
    }
}