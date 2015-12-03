<?php


namespace App\Lib\Helpers;


/**
 * Class JsonResponse
 * @package App\Lib\Helpers
 */
class JsonResponse
{
	/**
	 * @param array $dataArray
	 * @return string
	 */
	public static function fromArray($dataArray = [])
	{
		return json_encode(
			$dataArray,
			JSON_NUMERIC_CHECK
		);
	}

}