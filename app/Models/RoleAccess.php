<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 12/02/18
 * Time: 7:02
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    protected $table = 'role_access';

    protected $primaryKey = 'id';
}