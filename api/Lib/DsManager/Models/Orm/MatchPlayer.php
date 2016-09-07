<?php

namespace App\Lib\DsManager\Models\Orm;

/**
 * Class MatchPlayer
 * @package App\Lib\DsManager\Models\Orm
 */
class MatchPlayer extends DsManagerOrm
{

    /**
     * @var string
     */
    protected $table = 'match_players';

    /**
     * @var array
     */
    protected $fillable = [
        'match_id',
        'team_id',
        'player_id',
        'goals',
        'vote'
    ];

    protected $casts = [
        'vote' => 'integer',
        'goals' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeComplete($query){
        return $query->with(
            'team',
            'player'
        );
    }

}