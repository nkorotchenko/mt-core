<?php

abstract class Theme {

	private $___data = array();

	private $headerStrings = array();
	private $footerStrings = array();

	public $app = false;
	public $path = false;
	public $url = false;
	public $title = false;

	abstract public function Draw ($name, $params);

	public function __set($name, $value) 
	{
		 $this->___data[$name] = $value;
	}

	public function __get($name) 
	{
		 if (array_key_exists($name, $this->___data)) {
			return $this->___data[$name];
		}

		$trace = debug_backtrace();
		trigger_error(
			'Неопределенное свойство в __get(): ' . $name .
			' в файле ' . $trace[0]['file'] .
			' на строке ' . $trace[0]['line'],
			E_USER_NOTICE);
		return null;
	}

	public function __isset($name) 
	{
		 return isset($this->___data[$name]);
	}

	public function __unset($name) 
	{
		 unset($this->___data[$name]);
	}

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
			$theme->app = $app;
			$theme->path = PATH_THEME.strtolower("/$name");
			$theme->url = str_replace(PATH_SITE, "", PATH_THEME.strtolower("/$name"));
		}
		else
			return false;
		
		return $theme;
	}
}
?>