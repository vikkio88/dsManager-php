<?php

namespace App\Lib\DsManager\Models\Orm;

/**
 * Class LeagueRound
 * @package App\Lib\DsManager\Models\Orm
 */
class LeagueRound extends DsManagerOrm
{

    /**
     * @var string
     */
    protected $table = 'league_rounds';

    /**
     * @var array
     */
    protected $fillable = [
        'league_id',
        'day'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function league()
    {
        return $this->hasOne(League::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany(Match::class);
    }
}