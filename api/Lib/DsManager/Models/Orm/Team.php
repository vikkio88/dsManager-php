<?php
namespace App\Lib\DsManager\Models\Orm;


/**
 * Class Team
 * @package App\Lib\DsManager\Models\Orm
 */
class Team extends DsManagerOrm
{
    /**
     *
     */
    const PLAYED_LIMIT = 5;
    /**
     *
     */
    const FUTURE_LIMIT = 3;

    /**
     *
     */
    const TEAM_STATS_LIMIT = 5;

    /**
     * @var string
     */
    protected $table = 'teams';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'nationality'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roster()
    {
        return $this->hasMany(Player::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coach()
    {
        return $this->hasOne(Coach::class);
    }

    /**
     * @return mixed
     */
    public function playedMatchesHome()
    {
        return $this->hasMany(
            MatchResult::class,
            'home_team_id'
        )->where('simulated', true)
            ->orderBy('updated_at', 'DESC')
            ->limit(self::PLAYED_LIMIT);
    }

    /**
     * @return mixed
     */
    public function futureMatchesHome()
    {
        return $this->hasMany(
            MatchResult::class,
            'home_team_id'
        )->where('simulated', false)
            ->orderBy('updated_at', 'DESC')
            ->limit(self::FUTURE_LIMIT);
    }

    /**
     * @return mixed
     */
    public function playedMatchesAway()
    {
        return $this->hasMany(
            MatchResult::class,
            'away_team_id'
        )->where('simulated', true)
            ->orderBy('updated_at', 'DESC')
            ->limit(self::PLAYED_LIMIT);
    }

    /**
     * @return mixed
     */
    public function futureMatchesAway()
    {
        return $this->hasMany(
            MatchResult::class,
            'away_team_id'
        )->where('simulated', false)
            ->orderBy('updated_at', 'DESC')
            ->limit(self::FUTURE_LIMIT);
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeComplete($query)
    {
        return $query->with(
            'roster',
            'coach',
            'playedMatchesHome',
            'playedMatchesHome.awayTeam',
            'futureMatchesHome',
            'futureMatchesHome.awayTeam',
            'playedMatchesAway',
            'playedMatchesAway.homeTeam',
            'futureMatchesAway',
            'futureMatchesAway.homeTeam'
        );
    }

    /**
     * @return array
     */
    public static function getBest()
    {
        $result = Match::selectRaw('winner_id, COUNT(*) as won')
            ->whereNotNull('winner_id')->where('winner_id', '!=', 0)
            ->orderByRaw('COUNT(*) DESC')->groupBy('winner_id')
            ->take(self::TEAM_STATS_LIMIT)->get()->keyBy('winner_id')->toArray();
        $teams = Team::whereIn('id', array_keys($result))->get()->toArray();
        $result = array_map(function ($team) use ($result) {
            $team['stats'] = $result[$team['id']];
            return $team;
        }, $teams);

        return $result;
    }

}