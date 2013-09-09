<?php
namespace Upvote;
class Debug 
{
	/**
	 * Provide a convience method to dump data.
	 * 
	 * @param mixed $data
	 */
	public static function dump($data)
	{
		ob_start();
		if(function_exists('xdebug_var_dump'))
		{
			xdebug_var_dump($data);
		}
		else
		{
			var_dump($data);
		}
		ob_flush();
	}
}