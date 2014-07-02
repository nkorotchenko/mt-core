<?php

require_once( "app.php" );
require_once( "args.php" );
require_once( "route.php" );
require_once( "ini.php" );
require_once( "settings.php" );
require_once( "sql.php" );

class System {
	private static $settings = false;
	private static $sql = false;
	private static $sqlConnection = false;
	private static $args = false;
	
	public static $startTime;
	
	function __construct()
	{
	}
	
	public static function Init()
	{
		Args::Parse();
		
		self::$startTime = microtime(true);
		self::$settings = new SETTINGS();
		self::$settings->Init();
		
		Users::Init();
		Auth::Init();
	}
	
	public static function GetSettings()
	{
		return self::$settings;
	}
	
	public static function GetConnect()
	{
		if (!self::$sqlConnection)
		{
			self::$sql = new SQL();
			self::$sqlConnection = self::$sql->Open(self::$settings->Get("data_base"));
			
			if (!self::$sqlConnection)
				return false;
		}
		
		return self::$sql;
	}
	
	public static function Redirect($url)
	{
		header('Location: '.$url);
		exit();
	}
	
	public static function Dispose()
	{
		if (self::$sql)
			self::$sql->Close();
	}
	
	public static function DateAdd($interval, $number, $date)
	{
		$date_time_array = getdate($date);
		$hours = $date_time_array['hours'];
		$minutes = $date_time_array['minutes'];
		$seconds = $date_time_array['seconds'];
		$month = $date_time_array['mon'];
		$day = $date_time_array['mday'];
		$year = $date_time_array['year'];

		switch ($interval) {		
			case 'yyyy': $year+=$number; break;
			case 'q': $year+=($number*3); break;
			case 'm': $month+=$number; break;
			case 'y': case 'd': case 'w': $day+=$number; break;
			case 'ww': $day+=($number*7); break;
			case 'h': $hours+=$number; break;
			case 'n': $minutes+=$number; break;
			case 's': $seconds+=$number; break;            
		}
		
		$timestamp= mktime($hours,$minutes,$seconds,$month,$day,$year);
		
		return $timestamp;
	}
	
	public static function GetPageClass($args, $argNumber = 0)
	{
		$pageClass = "index";
		
		if (count($args) > $argNumber)
			$pageClass = $args[$argNumber];
			
		return $pageClass;
	}
	
	public static function IsPageClass($pageClass, $name)
	{
		return strcmp($pageClass, $name) == 0;
	}
	
	public static function IsAppExist($name)
	{
		$fileName = PATH_APP."/$name/$name.app.php";
	
		if (file_exists($fileName) == false) {
			return false;
		}
			
		require_once($fileName);
		
		$className = self::GenerateClassName($fileName);
		
		if(class_exists($className))
		{
			return true;
		}
		
		return false;
	}
	
	public static function RunApp($name, $args = null, $params = null)
	{
		$app = self::GetApp(PATH_APP."/$name/$name.app.php");
		
		if ($app)
		{
			if (empty($args))
				$args = Args::GetArgs();
				
			if (empty($params))
				$params = Args::GetParams();
				
			$app->main($args, $params);
		}
		
		return $app;
	}
	
	public static function GenerateClassName($fileName)
	{
		$baseFileName = ucfirst(strtolower(basename($fileName)));
		
		$extPos = strpos($baseFileName, ".");
		
		if ($extPos > 0)
			$baseFileName = substr($baseFileName, 0, $extPos);
		
		return $baseFileName."Application";
	}
	
	public static function GetApp($fileName, $className = null)
	{
		if (file_exists($fileName) == false) {			
			return false;
		}
		
		$baseClassName = self::GenerateClassName($fileName);
			
		if (!empty($className)) {		
			$baseClassName = $className;
		}
		
		$app = false;
		
		require_once($fileName);
		
		if(class_exists($baseClassName)) {
			$app = new $baseClassName();
			$app->path = dirname($fileName);
			$app->url = str_replace(dirname($app->path), "", $app->path);
		}
		else
			return false;
			
		return $app;
	}
	
}

?>