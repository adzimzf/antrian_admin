<?php

namespace App\Http\Controllers;

use App\Models\JenisCetakan;
use App\Models\JenisKertas;
use App\Models\SuratJalan;
use App\Models\SuratJalanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class DesignController extends Controller
{
    public function index(Request $request)
    {
        $jenisKertas    = JenisKertas::all();
        $jenisCetakan   = JenisCetakan::all();
        $nomerBon       = date("dmY")."001";
        $nod            = SuratJalan::where(['tanggal'=>date("Y-m-d")])->orderBy("created_at", "desc")->first();
        if ($nod != null){
            $nomer = substr($nod->id, 8)+1;
            $nomerBon = date("dmY").$this->addZero($nomer);
        }
        return view('designer.insert', ['jenisKertas'=>$jenisKertas, 'jenisCetakan'=>$jenisCetakan, 'nomerBon'=>$nomerBon]);
    }

    private function addZero($num)
    {
        if ($num < 10){
            return "00".$num;
        }elseif($num < 100){
            return "0".$num;
        }
        return $num;
    }

    public function insert(Request $request)
    {
        $this->validate($request,[
            'nomer-bon'             => "required",
            'tanggal-bon'           => "required",
            'nama-customer'         => "required",
            'nomer-telp-customer'   => "required"
        ]);

        $data = new SuratJalan();
        $data->id               = $request->input('nomer-bon');
        $data->nama             = $request->input('nama-customer');
        $data->no_telepon       = $request->input('nomer-telp-customer');
        $data->biaya_edit       = $request->input('biaya-edit');
        $data->biaya_setting    = $request->input('biaya-setting');
        $data->tanggal          = $request->input('tanggal-bon');
        $data->jam              = date("H:i:s");
        $data->operator         = 1;

        $status = false;

        DB::transaction(function () use ($data, &$status, $request) {
            if ($data->save()) {
                if ($this->insertDetail($request, $data->id)) {
                    $status = true;
                } else {
                    DB::rollback();
                }
            } else {
                DB::rollback();
            }
        });
        if ($status) {
            Session::flash('message_designer_add_spk','Berhasil menambahkan data');
            return redirect()->action('DesignController@index');
        } else {

        }

    }

    private function insertDetail(Request $request, $suratJalanId)
    {
        $length = sizeof($request->input("detail-sumber"));



        for($i = 0; $i < $length; $i++) {
            $data = new SuratJalanDetail();
            $data->surat_jalan_id   = $suratJalanId;
            $data->source           = $request->input("detail-sumber")[$i];
            $data->file_address     = $this->saveImage($request->file('detail-file')[$i]);
            $data->page             = $request->input("detail-halaman")[$i];
            $data->quantity         = $request->input("detail-banyaknya")[$i];
            $data->jenis_kertas_id  = $request->input("detail-jenis-kertas")[$i];
            $data->peper_size       = $request->input("detail-ukuran-kertas")[$i];
            $data->duplex           = $request->input("detail-duplex")[$i];
            $data->box              = $request->input("detail-box")[$i];

            if (!$data->save()){
                return false;
            }
        }
        return true;
    }

    private function saveImage($file) {
        if($file) {
            $extension = $file->getClientOriginalExtension();
            $namaFile = sha1(date("Y-m-d H:i:s")).".".$extension;
            $file->move('images/surat_jalan', $namaFile);
            return $namaFile;
        }
        return "";

    }
}
