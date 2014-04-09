<?php

abstract class Theme {
	private $headerStrings = array();
	private $footerStrings = array();
	public $path = false;
	public $url = false;
	public $title = false;
	
	abstract public function Draw ($name, $params);
	
	public function HeaderStrings()
	{
		foreach ($this->headerStrings as $str)
		{
			echo $str;
		}
	}
	
	public function FooterStrings()
	{
		foreach ($this->headerStrings as $str)
		{
			echo $str;
		}
	}
	
	public function AddHeader($str)
	{
		$headerStrings[] = $str;
	}
	
	public function AddFooter($str)
	{
		$footerStrings[] = $str;
	}
}

class Template {
	public static function Get($name, $app)
	{
		$fileName = PATH_THEME.strtolower("/$name/$name.theme.php");
	
		if (file_exists($fileName) == false)
			return false;
			
		require_once($fileName);
		
		$className = $name."Theme";
		
		$theme = false;
		
		if(class_exists($className))
		{
			$theme = new $className();
			$theme->appPath = $app->path;
			$theme->path = PATH_THEME.strtolower("/$name");
			$theme->url = str_replace(PATH_SITE, "", PATH_THEME.strtolower("/$name"));
		}
		else
			return false;
		
		return $theme;
	}
}
?>