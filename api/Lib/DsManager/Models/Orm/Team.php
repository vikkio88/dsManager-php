<?php
namespace App\Lib\DsManager\Models\Orm;


/**
 * Class Team
 * @package App\Lib\DsManager\Models\Orm
 */
class Team extends DsManagerOrm
{
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
     * @param $query
     * @return mixed
     */
    public function scopeComplete($query)
    {
        return $query->with(
            'roster',
            'coach'
        );
    }

}