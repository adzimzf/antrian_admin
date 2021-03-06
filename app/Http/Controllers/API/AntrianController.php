<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 19/03/18
 * Time: 8:34
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    public function set(Request $request)
    {
        Helper::validate($request, [
            "id_jadwal" => "required",
            "id_cust" => "required"
        ]);

        $id_jadwal = $request->input("id_jadwal");
        $id_cust = $request->input(["id_cust"]);

        //getJadwal
        $jadwal = DB::table("jadwal_rs")->where(["id"=>$id_jadwal])->first();

        //get last antrian
        $antrian = DB::table("antrian")
            ->where(["id_rs"=>$jadwal->id_rs, "id_poly"=>$jadwal->id_poly])
            ->join("rs", "rs.id", "antrian.id_rs")
            ->join("poly", "poly.id", "id_poly")
            ->orderBy("antrian_ke", "desc")
            ->first(["antrian_ke", DB::raw("rs.nama as nama_rs"), DB::raw("poly.nama as nama_poly")]);
        $antrian_ke = 0;
        if (count($antrian) != 0) {
            $antrian_ke = $antrian->antrian_ke;
        }
        $antrian_ke += 1;
        $nomerAntrian = $jadwal->id_poly."-".$antrian_ke;
        //insert ke antrian
        $data = DB::table("antrian")
            ->insertGetId([
                "id_rs" => $jadwal->id_rs,
                "id_poly"=> $jadwal->id_poly,
                "id_cust"=> $id_cust,
                "antrian_ke"=> $antrian_ke,
                "nomer_antrian"=> $nomerAntrian,
                "tanggal" => $jadwal->tanggal,
                "id_dokter" => $jadwal->id_dokter,
            ]);
        $res["antrian_ke"] = $antrian_ke;
        $res["id_antrian"] = $data;
        $res["nomer_antrian"] = $nomerAntrian;
        $res["id_rs"] = $jadwal->id_rs;
        $res["id_poly"] = $jadwal->id_poly;
        $res["tanggal"] = $jadwal->tanggal;
        $res["mulai_jam"] = $jadwal->mulai_jam;
        $res["nama_rs"] = $antrian->nama_rs;
        $res["nama_poly"] = $antrian->nama_poly;


        if ($data) {
            Helper::response(true, "Berhasil Ambil Antrian", $res);
        }
        Helper::response(true, "Gagal Ambil Antrian", null);
    }

    public function getDetail($id) {
        $dataAntrian = DB::select(DB::raw("
        SELECT 
        antrian.id AS antrian_id,
        antrian.antrian_ke AS antrian_ke,
        antrian.nomer_antrian as nomer_antrian,
        rs.id AS rs_id,
        rs.nama AS rs_nama,
        rs.alamat AS rs_alamat,
        poly.id AS poly_id,
        poly.nama AS poly_nama,
        users.id AS dokter_id,
        users.name AS dokter_nama
        FROM `antrian`
        JOIN rs ON rs.id = antrian.id_rs
        JOIN poly ON poly.id = antrian.id_poly
        JOIN users ON users.id = antrian.id_dokter
        WHERE
        antrian.id=$id"));
        Helper::response(true, "Data Detail", $dataAntrian);
    }

    public function getHistory($id)
    {
        $dataAntrian = DB::select(DB::raw("
        SELECT 
        antrian.id AS antrian_id,
        antrian.antrian_ke AS antrian_ke,
        antrian.nomer_antrian as nomer_antrian,
        rs.id AS rs_id,
        rs.nama AS rs_nama,
        rs.alamat AS rs_alamat,
        poly.id AS poly_id,
        poly.nama AS poly_nama,
        users.id AS dokter_id,
        users.name AS dokter_nama,
        antrian.tanggal AS tanggal,
        antrian.status as status
        FROM `antrian`
        JOIN rs ON rs.id = antrian.id_rs
        JOIN poly ON poly.id = antrian.id_poly
        JOIN users ON users.id = antrian.id_dokter
        WHERE
        antrian.id_cust='$id'
        ORDER BY antrian.tanggal DESC"));
        Helper::response(true, "Data Detail", $dataAntrian);
    }
}