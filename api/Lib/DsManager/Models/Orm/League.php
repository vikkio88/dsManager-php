<?php

namespace App\Lib\DsManager\Models\Orm;

/**
 * Class League
 * @package App\Lib\DsManager\Models\Orm
 */
class League extends DsManagerOrm
{
    /**
     * @var string
     */
    protected $table = 'leagues';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function match_days()
    {
        return $this->hasMany(MatchDay::class);
    }
} 