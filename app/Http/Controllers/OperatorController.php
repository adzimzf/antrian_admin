<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 10/02/18
 * Time: 23:34
 */

namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\SuratJalanDetail;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function getData(Request $request)
    {
        $data = SuratJalan::all();
        return view('operator.data', ['data'=>$data]);
    }


    public function getAjax(Request $request)
    {
        $noBon = $request->input("noBon");
        $nama  = $request->input("nama");

        if ($noBon != "" || $nama != "") {
            $data = SuratJalan::where("id", 'LIKE', "%".$noBon."%")
                ->where("nama", "LIKE", $nama."%")
                ->get();
            return [
                "success"   => "ok",
                "data"      => $data
            ];
        }
        return [
            "success"   => "error",
            "data"      => []
        ];
    }

    public function getProcess($id)
    {
        $suratJalan         = SuratJalan::where(['id'=>$id])->first();
        $suratJalanDetail   = SuratJalanDetail::where(['surat_jalan_id'=>$suratJalan->id])->get();
        return view('operator.process', ['suratJalan'=>$suratJalan, 'suratJalanDetail'=>$suratJalanDetail, 'edit'=>true]);
    }

    public function setDone(Request $request)
    {
        $id = $request->input("id");

        $data = SuratJalanDetail::where(["id"=>$id]);
        $data->update([
            "done" => 1
        ]);
    }
}