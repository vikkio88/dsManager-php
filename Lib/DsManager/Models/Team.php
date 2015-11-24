<?php

namespace App\Lib\DsManager\Models;

/**
 * Class Team
 * @package App\Lib\DsManager\Models
 */
/**
 * Class Team
 * @package App\Lib\DsManager\Models
 */
class Team
{
	/**
	 * @var
	 */
	public $name;
	/**
	 * @var
	 */
	public $coach;
	/**
	 * @var
	 */
	public $roster;

	/**
	 * @return array
	 */
	public function toArray()
	{
		$result = [];
		$result['name'] = $this->name;
		$result['coach'] = $this->coach->toArray();
		$roster = [];
		foreach ($this->roster as $player) {
			$roster[] = $player->toArray();
		}
		$result['roster'] = $roster;
		return $result;
	}
}