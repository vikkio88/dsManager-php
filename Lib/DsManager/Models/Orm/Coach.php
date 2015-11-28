<?php

namespace App\Lib\DsManager\Models\Orm;


/**
 * Class Coach
 * @package App\Lib\DsManager\Models\Orm
 */
class Coach extends DsManagerOrm
{
    /**
     * @var string
     */
    protected $table = 'coaches';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'age',
        'nationality',
        'skillAvg',
        'wageReq',
        'favouriteModule'
    ];

} 