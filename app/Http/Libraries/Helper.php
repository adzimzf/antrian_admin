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
    public static function getCusId($request)
    {
        $token = explode(" ", $request->header("Authorization"))[1];
        try {
            $credentials = JWT::decode($token, env('SECRET_KEY'), ['HS256']);
        } catch(ExpiredException $e) {
            header('Content-Type: application/json');
            exit(json_encode([
                'error' => 'Provided token is expired.'
            ], 400));
        } catch(Exception $e) {
            header('Content-Type: application/json');
            exit(json_encode([
                'error' => 'An error while decoding token.'
            ], 400));
        }
        return $credentials->uid;
    }

    public static function validate($request, $data)
    {
        $validator = Valid::make($request->all(), $data);

        $errors = $validator->errors();
        $errors = $errors->all();

        if ($errors) {
            header('Content-Type: application/json');
            exit(json_encode([
                "status" => "error",
                "message" => $errors[0],
                "data" => null
            ]));
        }
    }

    public static function response($status, $message, $data)
    {
        $st = $status ? "success" : "error";
        header('Content-Type: application/json');
        exit(json_encode([
            "status" => $st,
            "message" => $message,
            "data" => $data
        ]));
    }


}