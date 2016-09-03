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
        'name',
        'teams'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rounds()
    {
        return $this->hasMany(LeagueRound::class);
    }
} 