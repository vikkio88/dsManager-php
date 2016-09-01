<?php

namespace App\Lib\DsManager\Models\Orm;

/**
 * Class MatchResult
 * @package App\Lib\DsManager\Models\Orm
 */
class MatchResult extends Match
{
    /**
     * @var array
     */
    protected $fillable = [
        'goal_home',
        'goal_away',
        'info',
        'simulated'
    ];

    protected $hidden = [
        'home_team_id',
        'away_team_id',
        'created_at',
        'updated_at'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'info' => 'json',
        'simulated' => 'boolean'
    ];

    public static function resolveAttributes(array $attributes, $matchId)
    {
        if (array_key_exists('info', $attributes)) {
            if (array_key_exists('scorers', $attributes['info'])) {
                foreach ($attributes['info']['scorers']['home'] as $scorerHome) {
                    self::addScorer($matchId, $attributes['home_team_id'], $scorerHome->id);
                }
                foreach ($attributes['info']['scorers']['away'] as $scorerAway) {
                    self::addScorer($matchId, $attributes['away_team_id'], $scorerAway->id);
                }
                unset($attributes['info']['scorers']);
            }
            $attributes['info'] = json_encode($attributes['info']);
        }
        return $attributes;
    }

    private static function addScorer($matchId, $teamId, $playerId)
    {
        $scorer = MatchPlayer::where(
            [
                'match_id' => $matchId,
                'team_id' => $teamId,
                'player_id' => $playerId
            ]
        )->where('goals', '>', 0)->first();
        if (!empty($scorer)) {
            $scorer->goals = $scorer->goals + 1;
            $scorer->vote = $scorer->vote + rand(0, 1);
            $scorer->save();
        } else {
            MatchPlayer::create(
                [
                    'match_id' => $matchId,
                    'team_id' => $teamId,
                    'player_id' => $playerId,
                    'goals' => 1
                ]
            );
        }
    }

    public function scorers()
    {
        return $this->belongsToMany(
            Player::class,
            'match_players',
            'match_id'
        )->withPivot('team_id')->where(
            'goals', '>', 0
        );
    }

    public function scopeComplete($query)
    {
        return parent::scopeComplete($query)->with('scorers');
    }


}