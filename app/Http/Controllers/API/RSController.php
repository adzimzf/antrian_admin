<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 17/03/18
 * Time: 16:37
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Helper;
use DateTime;
use Illuminate\Support\Facades\DB;

class RSController extends Controller
{
    public function getByNameAndPoly($name = "", $poly = "") {
        if ($name == "_"){
            $name = "";
        }
        if ($poly == "_"){
            $poly = "";
        }
        $rs = DB::table("rs")->where("nama", "like", "%".$name."%")->get();

        $res = array();
        foreach ($rs as $rs) {
            $polyS = DB::select(DB::raw("
            SELECT `poly`.`nama` FROM `rs_poly`
            JOIN `poly` ON `rs_poly`.`poly`=`poly`.`id`
            JOIN `rs` ON `rs_poly`.`id_rs`=`rs`.`id`
            WHERE `rs`.`nama` = '$rs->nama' AND `poly`.`nama` LIKE '$poly%'"));
            if (count($polyS) == 0) {
                continue;
            }
            $polyA = array();
            foreach ($polyS as $polyS) {
                array_push($polyA, $polyS->nama);
            }
            $re = array();
            $re["id"] = $rs->id;
            $re["nama"] = $rs->nama;
            $re["alamat"] = $rs->alamat;
            $re["poly"] = $polyA;
            array_push($res, $re);
        }
        Helper::response(true, "Success Get RS", $res);
    }

    public function getJadwalByName($id) {
        $datetime = new DateTime('tomorrow');
        $tangal = $datetime->format('Y-m-d');

        $jadwal = DB::select(DB::raw(
            "SELECT 
            jadwal_rs.id as id_jadwal,
            jadwal_rs.tanggal,
            jadwal_rs.mulai_jam,
            rs.nama as rs,
            poly.nama as poly,
            users.name as dokter
            
            FROM `jadwal_rs`
            JOIN rs ON jadwal_rs.id_rs=rs.id
            JOIN users ON jadwal_rs.id_dokter=users.id
            JOIN poly ON jadwal_rs.id_poly = poly.id
            WHERE
            rs.id = '$id'"
        ));
        Helper::response(true, "Success get Jadwal", $jadwal);
    }
}