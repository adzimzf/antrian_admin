<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 14/02/18
 * Time: 23:13
 */

namespace App\Http\Libraries;

use \Firebase\JWT\JWT;
use Validator as Valid;

class Helper
{
    public static function getCusId($data)
    {
        $token = explode(" ", $data)[1];
        try {
            $credentials = JWT::decode($token, env('SECRET_KEY'), ['HS256']);
        } catch(ExpiredException $e) {
            header('Content-Type: application/json');
            exit(response()->json([
                'error' => 'Provided token is expired.'
            ], 400));
        } catch(Exception $e) {
            header('Content-Type: application/json');
            exit(response()->json([
                'error' => 'An error while decoding token.'
            ], 400));
        }
        return $credentials->aud;
    }

    public static function validate($request, $data)
    {
        $validator = Valid::make($request->all(), $data);

        $errors = $validator->errors();
        $errors = $errors->all();

        if ($errors) {
            header('Content-Type: application/json');
            exit(response()->json([
                "status" => "error",
                "message" => $errors[0],
                "data" => null
            ]));
        }
    }


}