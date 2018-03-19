<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 19/03/18
 * Time: 8:34
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Libraries\Helper;

class AntrianController extends Controller
{
    public function set(Request $request)
    {
        Helper::validate($request, [
            "id_rs" => "required",
            "id_poly" => "required",
            "id_cust" => "required",
        ]);

        $id_rs = $request->input("id_rs");
        $id_poly = $request->input("id_poly");
        $id_cust = $request->input(["id_cust"]);

        //get last antrian
        $antrian = DB::table("antrian")
            ->where(["id_rs"=>$id_rs, "id_poly"=>$id_poly])
            ->orderBy("antrian_ke", "desc")
            ->limit(1)
            ->get(["antrian_ke"]);
        $antrian_ke = 0;
        if (count($antrian) != 0) {
            $antrian_ke = $antrian->antrian_ke();
        }

        echo $antrian_ke;
    }
}