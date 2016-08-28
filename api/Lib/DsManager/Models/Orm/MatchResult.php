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

    public static function castAttributes($attributes = [])
    {
        if (array_key_exists('info', $attributes)) {
            $attributes['info'] = json_encode($attributes['info']);
        }
        return $attributes;
    }
}