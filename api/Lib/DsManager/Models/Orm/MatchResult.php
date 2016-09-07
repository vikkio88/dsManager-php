<?php

namespace App\Lib\DsManager\Models\Orm;

use App\Lib\DsManager\Helpers\Randomizer;

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
        'simulated',
        'winner_id',
        'loser_id',
        'is_draw'
    ];

    protected $hidden = [
        'home_team_id',
        'away_team_id',
        'winner_id',
        'loser_id',
        'is_draw',
        'created_at',
        'updated_at'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'simulated' => 'boolean'
    ];

    public static function resolveAttributes(array $attributes, $matchId)
    {
        self::generateAppearances(
            [
                $attributes['home_team_id'],
                $attributes['away_team_id']
            ],
            $matchId
        );
        $attributes = self::setResult($attributes);
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
        }
        unset($attributes['info']);
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
        )->first();
        if (!empty($scorer)) {
            $scorer->goals = $scorer->goals + 1;
            $scorer->vote = $scorer->vote <= 9 ? $scorer->vote + rand(0, 1) : $scorer->vote;
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

    private static function generateAppearances(
        $teamIds,
        $matchId
    )
    {
        foreach ($teamIds as $id) {
            $players = Player::where('team_id', $id)->get()->random(11);
            foreach ($players as $player) {
                MatchPlayer::create(
                    [
                        'match_id' => $matchId,
                        'team_id' => $id,
                        'player_id' => $player->id,
                        'vote' => Randomizer::voteFromSkill($player->skillAvg)
                    ]
                );
            }
        }
    }

    private static function setResult($attributes)
    {
        $toExtract = [
            'winner_id' => 'winner_id',
            'loser_id' => 'loser_id',
            'is_draw' => 'is_draw'
        ];
        if (array_key_exists('info', $attributes)) {
            foreach ($toExtract as $key => $attr) {
                $attributes[$attr] = $attributes['info'][$key];
                unset($attributes['info'][$key]);
            }
        }
        return $attributes;
    }

    public function scorers()
    {
        return $this->belongsToMany(
            Player::class,
            'match_players',
            'match_id'
        )->withPivot(
            'team_id',
            'goals'
        )->where(
            'goals', ' > ', 0
        );
    }

    public function scopeComplete($query)
    {
        return parent::scopeComplete($query)->with('scorers');
    }


}