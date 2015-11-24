<?php

namespace App\Lib\DsManager\Models;
use App\Lib\DsManager\Models\Common\Person;

/**
 * Class Player
 * @package App\Lib\DsManager\Models
 */
class Player extends Person
{
	/**
	 * @var
	 */
	public $role;

	/**
	 * @return array
	 */
	public function toArray()
	{
		$result = parent::toArray();
		$result["role"] = $this->role;

		return $result;
	}
}