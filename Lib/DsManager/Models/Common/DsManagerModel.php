<?php


namespace App\Lib\DsManager\Models\Common;


use App\Lib\DsManager\Models\Common\Interfaces\ActiveModel;

/**
 * Class DsManagerModel
 * @package App\Lib\DsManager\Models\Common
 */
abstract class DsManagerModel implements ActiveModel
{
    /**
     * @var
     */
    public $id;

    /**
     * @return mixed
     */
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