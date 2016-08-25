<?php
namespace App\Lib\DsManager\Models\Orm;

use Illuminate\Database\Eloquent\Model as Eloquent;


abstract class DsManagerOrm extends Eloquent{

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

} 