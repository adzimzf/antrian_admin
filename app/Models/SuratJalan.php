<?php
/**
 * Created by PhpStorm.
 * User: AdzimZF
 * Date: 12/22/17
 * Time: 7:01 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    protected $table = 'surat_jalan';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public function getSuratJalanDetail()
    {
        return $this->hasOne("App\Models\SuratJalanDetail", 'surat_jalan_id', 'id');
    }
}