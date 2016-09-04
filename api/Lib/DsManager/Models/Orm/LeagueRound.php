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
        'day',
        'simulated'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'simulated' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function league()
    {
        return $this->belongsTo(League::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany(Match::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeComplete($query)
    {
        return $query->with(
            'league',
            'matches',
            'matches.homeTeam',
            'matches.AwayTeam'
        );
    }
}