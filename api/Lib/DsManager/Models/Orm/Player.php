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

}