<?php

////////////////////////////////////////////////////////////////////////
// LANGUAGE SYSTEM

class Language {

	private static $__name = null;

	public static function Init()
	{
		$settings = System::GetSettings();
		
		if ($settings->lang["multi"] != 0) {
			if (empty($_COOKIE["lang"]))
				self::$__name = $settings->lang["default"];
			else 
				self::$__name = $_COOKIE["lang"];
				
			setcookie("lang", self::$__name, time() + 3600*24*3, "/");
		}
		else {
			self::$__name = $settings->lang["default"];
		}
	}
	
	public static function Name()
	{
		return self::$__name;
	}
}

?>