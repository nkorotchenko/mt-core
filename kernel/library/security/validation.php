<?php

class Valid {

	public static function Is($pattern, $value, $lenght = null)
	{
		if (preg_match( $pattern, $value ))
		{
			if (!empty($lenght) && strlen($value) > $lenght) {
				return false;
			}
			return true;
		}
		return false;
	}

	public static function IsNumber($value, $lenght = null)
		{return self::Is("/^([0-9])+$/", $value, $lenght);}
		
	public static function IsHex($value, $lenght = null)
		{return self::Is("/^([0-9a-f])+$/", $value, $lenght);}
		
	public static function IsFloat($value, $lenght = null)
		{return self::Is("/^([0-9.])+$/", $value, $lenght);}
		
	public static function IsString($value, $lenght = null)
		{return self::Is("/^([a-z\x80-\xFF_ ])+$/i", $value, $lenght);}
		
	public static function IsEnString($value, $lenght = null)
		{return self::Is("/^([a-z_ ])+$/i", $value, $lenght);}
		
	public static function IsRuString($value, $lenght = null)
		{return self::Is("/^([\x80-\xFF_ ])+$/i", $value, $lenght);}
		
	public static function IsEmail($value, $lenght = null)
		{return self::Is("/^([\w\.\-])+@([\w\.\-]+\\.)+[a-z]{2,4}$/i", $value, $lenght);}
		
	public static function IsName($value, $lenght = null)
		{return self::Is("/^([a-zA-Z_0-9])+$/", $value, $lenght);}
		
	public static function IsParamName($value, $lenght = null)
		{return self::Is("/^[a-z]([a-z_0-9])+$/i", $value, $lenght);}
}

?>