<?php

namespace App\Lib\DsManager\Models\Orm;

/**
 * Class Player
 * @package App\Lib\DsManager\Models
 */
class Player extends DsManagerOrm
{

    /**
     * @var string
     */
    protected $table = 'players';

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
        'val',
        'role',
        'team_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function lastMatches()
    {
        return $this->hasMany(MatchPlayer::class)
            ->orderBy('updated_at', 'DESC')
            ->limit(5);
    }

    public function goals()
    {
        return $this->hasOne(MatchPlayer::class)
            ->selectRaw('player_id, sum(goals) as count')
            ->groupBy('player_id');
    }

    public function appearances()
    {
        return $this->hasOne(MatchPlayer::class)
            ->selectRaw('player_id, count(match_id) as count')
            ->groupBy('player_id');
    }

    public function avg()
    {
        return $this->hasOne(MatchPlayer::class)
            ->selectRaw('player_id, round(avg(vote),2) as avg')
            ->groupBy('player_id');
    }

    public function scopeStatistics($query)
    {
        return $query->with(
            'goals',
            'appearances',
            'avg',
            'lastMatches',
            'team'
        );
    }
}