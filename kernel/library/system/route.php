<?php

class Route {

	public static $rootDictionary = array("index");

	public static function Start()
	{
		Args::Parse();		
		
		/*$this->args = ARGS();
		$argsList = $this->args->GetArgs();
		$paramsList = $this->args->GetParams();*/
	}
	
	public function RunApp($path)
	{
	}
};

?>
