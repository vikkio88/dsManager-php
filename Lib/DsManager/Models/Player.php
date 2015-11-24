<?php

namespace App\Lib\DsManager\Models;
use App\Lib\DsManager\Models\Common\Person;

/**
 * Class Player
 * @package App\Lib\DsManager\Models
 */
class Player extends Person
{
	public $role;

	public function toArray()
	{
		$result = parent::toArray();
		$result["role"] = $this->role;

		return $result;
	}
}