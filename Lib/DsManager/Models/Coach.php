<?php

namespace App\Lib\DsManager\Models;
use App\Lib\DsManager\Models\Common\Person;


/**
 * Class Coach
 * @package App\Lib\DsManager\Models
 */
class Coach extends Person
{
	public $favouriteModule;

	public function toArray()
	{
		$result = parent::toArray();
		$result["favouriteModule"] = $this->favouriteModule;

		return $result;
	}
}