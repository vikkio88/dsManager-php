<?php

namespace App\Lib\DsManager\Models\Orm;

/**
 * Class Player
 * @package App\Lib\DsManager\Models
 */
class Player extends DsManagerOrm
{

    protected $table = 'players';

    protected $fillable =[
        'name',
        'surname',
        'age',
        'nationality',
        'skillAvg',
        'wageReq',
        'val',
        'role'
    ];

}