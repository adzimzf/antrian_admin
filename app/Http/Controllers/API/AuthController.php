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
use App\Models\Customers;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $field = "email";
        $param = $request->input("email");
        if(!filter_var($request->input("email"), FILTER_VALIDATE_EMAIL)) {
            $field = "username";
        }

        Helper::validate($request, [
            "password"  => "required"
        ]);

        $password = $request->input("password");

        $cus   = Customers::where([$field=>$param, "password"=>md5($password)])->first();
        if (!$cus){
            Helper::response(false, "invalid $field and password", null);
        } else {
            $payload = [
                "uid"  => $cus->id,
                "time" => date("Y-m-d H:m:i")
            ];
            $token = JWT::encode($payload, env("SECRET_KEY"), "HS256");
            $cus = Customers::where([$field=>$param, "password"=>md5($password), "is_login"=>0])
                ->update([
                    "auth_token" => $token,
                    "is_login"   => 1
                ]);
            if ($cus == 1) {
                $data["user"] = Customers::where([$field=>$param, "password"=>md5($password)])->first();
                Helper::response(true, "Success Login", $data);
            }else{
                Helper::response(false, "Account already login", null);
            }
        }
    }

    public function register(Request $request)
    {
        Helper::validate($request, [
            "fullname"  => "required",
            "username"  => "required",
            "email"     => "required|email",
            "password"  => "required"
        ]);

        $fullname = $request->input("fullname");
        $password = $request->input("password");
        $username = $request->input("username");
        $email    = $request->input("email");

        $cus      = new Customers();
        $cus->fullname      = $fullname;
        $cus->username      = $username;
        $cus->email         = $email;
        $cus->password      = $this->encryptPassword($password);

        $this->isExist($username, $email);

        try{
            if ($cus->save()) {
                Helper::response(true, "Success Register", null);
            }else{
                Helper::response(false, "Failed Register", null);
            }
        }catch (\Exception $e) {
            Helper::response(false, $e->getMessage(), null);
        }

    }

    private function encryptPassword($plaintext)
    {
        return md5($plaintext);
    }

    private function isExist($username, $email)
    {
        $cus = Customers::where(["email"=>$email])->orWhere(["username"=>$username])->first();
        if ($cus){
            Helper::response(false, "Username or email already exist", null);
        }
    }

    public function logout(Request $request)
    {
        $cusid  = Helper::getCusId($request);
        $res    = Customers::where(["id"=>$cusid])->update(["is_login"=>0, "auth_token"=>""]);
        if ($res == 1) {
            Helper::response(true, "Success logout", null);
        }
        Helper::response(false, "Error logout", null);
    }
}