<?php
/**
 * Created by PhpStorm.
 * User: AdzimZF
 * Date: 12/22/17
 * Time: 6:09 AM
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKertas extends Model
{
    protected $table = 'jenis_kertas';

    protected $primaryKey = 'id';

    public function suratJalanId()
    {
        return $this->belongsTo('App\Models\SuratJalanDetail');
    }
}