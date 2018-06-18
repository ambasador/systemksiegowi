<?php
namespace App\Traits;

trait TextTransform
{

	public static function tl($text)
	{
		return strtolower( trim($text) );
	}

	/**
	 * Explodes date
	 * @param  string $text '2016-05-19'
	 * @return array       ['y'=>'2016','m'=>'5','d'=>'19']
	 */
	public static function ed_ymd($date)
	{
		$date = trim($date);
		$date = explode('-', $date);
		return ['y'=> (int)$date[0], 'm'=> (int)$date[1], 'd'=> (int)$date[2]];
	}

	/**
	 * Explodes date
	 * @param  string $text '31/05'
	 * @return array       ['m'=>'5','d'=>'31']
	 */
	public static function ed_dm($date)
	{
		$date = trim($date);
		$date = explode('/', $date);
		return ['m'=> (int)$date[1], 'd'=> (int)$date[0]];
	}

}

