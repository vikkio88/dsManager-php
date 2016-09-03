<?php

namespace App\Lib\DsManager\Models\Orm;

/**
 * Class Match
 * @package App\Lib\DsManager\Models\Orm
 */
class Match extends DsManagerOrm
{

    /**
     * @var string
     */
    protected $table = 'matches';

    /**
     * @var array
     */
    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'league_round_id'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'home_team_id',
        'away_team_id',
        'created_at',
        'updated_at',
        'info'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'simulated' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function scopeTeams($query)
    {
        return $query->with(
            'homeTeam',
            'awayTeam'
        );
    }

    public function scopeComplete($query)
    {
        return $query->with(
            'homeTeam',
            'homeTeam.roster',
            'homeTeam.coach',
            'awayTeam',
            'awayTeam.roster',
            'awayTeam.coach'
        );
    }

}