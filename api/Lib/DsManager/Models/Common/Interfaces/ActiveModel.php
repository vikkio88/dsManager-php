<?php


namespace App\Lib\DsManager\Models\Common\Interfaces;


/**
 * Interface ActiveModel
 * @package App\Lib\DsManager\Models\Common\Interfaces
 */
interface ActiveModel
{
	/**
	 * @return mixed
	 */
	public function toArray();

	/**
	 * @return mixed
	 */
	public static function fromArray();

}