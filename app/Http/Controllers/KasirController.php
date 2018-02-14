<?php

namespace App\Http\Controllers;

use App\Models\JenisCetakan;
use App\Models\SuratJalan;
use App\Models\SuratJalanDetail;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function getData(Request $request)
    {
        $data = SuratJalan::all();
        $dataDetail = SuratJalanDetail::all();
        return view('kasir.data', ['data'=>$data]);
    }

    public function getProcess($id)
    {
        $suratJalan         = SuratJalan::where(['id'=>$id])->first();
        $suratJalanDetail   = SuratJalanDetail::where(['surat_jalan_id'=>$suratJalan->id])->get();
        return view('kasir.process', ['suratJalan'=>$suratJalan, 'suratJalanDetail'=>$suratJalanDetail, 'edit'=>true]);
    }

    public function getDetail($id)
    {
        $suratJalan  = SuratJalan::where(['id'=>$id])->first();
        $suratJalanDetail = SuratJalanDetail::where(['surat_jalan_id'=>$suratJalan->id])->get();
        return view('kasir.process', ['suratJalan'=>$suratJalan, 'suratJalanDetail'=>$suratJalanDetail, 'edit'=>false]);
    }

    public function setHarga(Request $request)
    {
        //update data surat jalan
        $suratJalan = SuratJalan::where(['id'=>$request->input("id")]);
        $suratJalan->update([
            "total1"        =>$request->input("total1"),
            "total2"        =>$request->input("total2"),
            "uang_muka"     =>$request->input("uang-muka"),
            "sisa"          =>$request->input("sisa"),
        ]);

        $dataDetail = json_decode($request->input("data-detail"));
        foreach ($dataDetail as $dataDetail) {
            $suratJalanDetail = SuratJalanDetail::where(["id"=>$dataDetail->detail_id])
                ->update([
                    "harga_satuan"    => $dataDetail->harga_satuan,
                    "harga_jumlah"    => $dataDetail->harga_jumlah,
                ]);
        }

        return "ok";
    }

    public function getAjax(Request $request)
    {
        $noBon = $request->input("noBon");
        $nama  = $request->input("nama");

        if ($noBon != "" || $nama != "") {
            $data = SuratJalan::where("id", 'LIKE', "%".$noBon."%")
                ->where("nama", "LIKE", $nama."%")
                ->get();
            $res = array();
            foreach ($data as $val) {
                $all = $val->getSuratJalanDetail()->count();
                $done = $val->getSuratJalanDetail()->where(["done"=>1])->count();
                $proses = ($done/$all*100);
                $res[]= [
                    "id"        => $val->id,
                    "nama"      => $val->nama,
                    "total2"    => $val->total2,
                    "uang_muka" => $val->uang_muka,
                    "proses"    => $proses
                ];
            }
            return [
                "success"   => "ok",
                "data"      => $res
            ];
        }
        return [
            "success"   => "error",
            "data"      => []
        ];
    }

    public function printBon($id)
    {
        $suratJalan     = SuratJalan::where(["id"=>$id])->first();
        $suratJalanDetail= SuratJalanDetail::where(["surat_jalan_id"=>$id])->get();
        return view("print.bon", ["suratJalan"=>$suratJalan, "suratJalanDetail"=>$suratJalanDetail]);
    }
}
