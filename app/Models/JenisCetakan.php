<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 05/02/18
 * Time: 6:37
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisCetakan extends Model
{
    protected $table = 'jenis_cetakan';

    protected $primaryKey = 'id';

    public function suratJalanId()
    {
        return $this->belongsTo('App\Models\SuratJalanDetail');
    }
}