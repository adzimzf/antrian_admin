<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 17/03/18
 * Time: 16:09
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Libraries\Helper;

class PolyController extends Controller
{
    public function get() {
        $poly = DB::table("poly")->get(["nama"]);
        Helper::response(true, "Success Get Poly", $poly);
    }
}