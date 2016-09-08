<?php

namespace App\Lib\DsManager\Models\Orm;

/**
 * Class Player
 * @package App\Lib\DsManager\Models\Orm
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

    /**
     * @return mixed
     */
    public function lastMatches()
    {
        return $this->hasMany(MatchPlayer::class)
            ->orderBy('updated_at', 'DESC')
            ->limit(5);
    }

    /**
     * @return mixed
     */
    public function goals()
    {
        return $this->hasOne(MatchPlayer::class)
            ->selectRaw('player_id, sum(goals) as count')
            ->groupBy('player_id');
    }

    /**
     * @return mixed
     */
    public function appearances()
    {
        return $this->hasOne(MatchPlayer::class)
            ->selectRaw('player_id, count(match_id) as count')
            ->groupBy('player_id');
    }

    /**
     * @return mixed
     */
    public function avg()
    {
        return $this->hasOne(MatchPlayer::class)
            ->selectRaw('player_id, round(avg(vote),2) as avg')
            ->groupBy('player_id');
    }

    /**
     * @param $query
     * @return mixed
     */
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

    /**
     * @return array
     */
    public static function getBest()
    {
        $result = MatchPlayer::selectRaw(
            'player_id, COUNT(*) as appearances ,AVG(vote) avg, SUM(goals) goals'
        )->where('goals', '>', 0)
            ->orderByRaw('SUM(goals) DESC,COUNT(*) DESC')
            ->groupBy('player_id')->take(20)->get()->keyBy('player_id')->toArray();
        $players = Player::with('team')->whereIn('id', array_keys($result))->get()->toArray();
        $result = array_map(function ($player) use ($result) {
            $player['stats'] = $result[$player['id']];
            return $player;
        }, $players);
        return $result;
    }
}