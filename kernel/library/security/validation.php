<?php

function Validate($pattern, $value, $lenght = false)
{
	$ValidationPatterns = array(
	"number" => "/^([0-9])+$/",
	"hex" => "/^([0-9a-f])+$/",
	"float" => "/^([0-9.])+$/",
	"string" => "/^([a-zA-Z_0-9 ])+$/",
	"ruString" => "/^([\x80-\xFF_0-9 ])+$/i",
	"email" => "/^([\w\.\-])+@([\w\.\-]+\\.)+[a-z]{2,4}$/i",
	"routeApi" => "/^([a-zA-Z_0-9])+$/");
	
	$result = false;
	if (is_array($pattern) && is_array($value))
	{
	}
	else if (!is_array($pattern) && is_array($value))
	{
		$result = array();
		foreach($value as $key => $val)
		{
			if (is_array($val))
			{
			}
			else
			{
				if (empty($ValidationPatterns[$pattern]))
					continue;
					
				if (preg_match( $ValidationPatterns[$pattern], $val ))
				{
					$result[$key] = $val;
				}
			}
		}
	}
	return $result;
}

?>