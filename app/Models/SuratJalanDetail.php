<?php
/**
 * Created by PhpStorm.
 * User: AdzimZF
 * Date: 12/22/17
 * Time: 7:03 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalanDetail extends Model
{
    protected $table = 'surat_jalan_detail';
    protected $primaryKey = 'id';

    public function jenisKertas()
    {
        return $this->hasOne("App\Models\JenisKertas", 'id', 'jenis_kertas_id');
    }

    public function jenisCetakan()
    {
        return $this->hasOne('App\Models\JenisCetakan', 'id', 'source');
    }
}