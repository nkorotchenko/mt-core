<?php

////////////////////////////////////////////////////////////////////////
// ERROR SYSTEM

function __ERROR_TRIGGER__($text, $type)
{
	$trace = debug_backtrace();
	$currentTrace = null;
	
	if (count($trace) > 3) {
		$currentTrace = $trace[2];
	}
	else if (count($trace) != 0) {
		$currentTrace = $trace[2];
	}
	else {
		trigger_error($text, $type);
		return;
	}
	
	$classAndFunctionName = null;
		
	if (!empty($currentTrace["class"]))
		$classAndFunctionName .= $currentTrace["class"];
		
	if (!empty($currentTrace["function"])) {
		if (!empty($currentTrace["class"]))
			$classAndFunctionName .= "::";
		$classAndFunctionName .= $currentTrace["function"];
	}
	
	if (!empty($classAndFunctionName)) {
		$classAndFunctionName = " <".$classAndFunctionName.">";
	}
	
	trigger_error(basename($currentTrace["file"])."[".$currentTrace["line"]."]"
		.$classAndFunctionName.": ".$text, $type);
	
	//var_dump($trace);
}

function _error($text)
{
	__ERROR_TRIGGER__($text, E_USER_ERROR);
	die();
}

function _warning($text)
{
	__ERROR_TRIGGER__($text, E_USER_WARNING);
}
?>