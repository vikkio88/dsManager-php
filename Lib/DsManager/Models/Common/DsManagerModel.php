<?php


namespace App\Lib\DsManager\Models\Common;


use App\Lib\DsManager\Models\Common\Interfaces\ActiveModel;

abstract class DsManagerModel implements ActiveModel
{
	abstract function toArray();
	/**
	 * @param array $array
	 * @return mixed
	 */
	public static function fromArray($array =[])
	{
		$class = get_called_class();
		$class = new $class();
		foreach ($array as $key => $value) {
			$class->$key = $value;
		}
		return $class;
	}
}