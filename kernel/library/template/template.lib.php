<?php

////////////////////////////////////////////////////////////////////////

class Template {

	private $sourceText = null;	// template contents

	private $name = null;			// template name
	private $path = null;			// template path
	private $url = null;			// theme url
	
	private $regions = array();
	private $params = array();

	public function __construct($fileName, $url)
	{
		$this->url = $url;
		$this->Load($fileName);
	}
	
	public function Load($fileName)
	{
		if (!empty($fileName)) {
		
			if (file_exists($fileName) == false) {
				_error("Template '$fileName' not exist");
				return false;
			}
		
			$this->name = basename($fileName);
			$this->path = dirname($fileName);
			$this->sourceText = file_get_contents($fileName);
			
			$regions = null;
			
			if(preg_match_all("/\{(.*?)\}/", $this->sourceText, $regions) != false) {
				$regions = array_unique($regions[1]);
				
				foreach ($regions as $region) {
				
					if (Valid::IsParamName($region)) {
						if (in_array("/".$region, $regions)) {
							$this->regions[$region] = $this->ParseRegion($region);
						}
						else {
							$this->params[$region] = false;
						}
					}
				}
			}		
			
			////////////////////////////////
			// Default params
			if (isset($this->params["url"])) {
				$this->params["url"] = $this->url;
			}
		}
		
		return true;
	}
	
	public function ParseRegion($name)
	{
		$regionStart = "{".$name."}";
		$regionEnd = "{/".$name."}";
		
		$cutStart = strpos($this->sourceText, $regionStart);
		$cutEnd = strpos($this->sourceText, $regionEnd);
		
		if ($cutStart === false || $cutEnd === false)
			return null;
		
		$cutStart += strlen($regionStart);
		
		$cutLength = $cutEnd - $cutStart;
		
		$region = substr($this->sourceText, $cutStart, $cutLength);
		
		return $region;
	}
	
	public function GetRegion($name)
	{
		return (isset($this->regions[$name])) ? $this->regions[$name] : null;
	}
	
	public function SetRegion($name, $value)
	{
		if (!isset($this->regions[$name])) {
			_error("Region '$name' not exist");
		}
		$this->regions[$name] = value;
	}
	
	public function DrawRegion($name)
	{
		if (isset($this->regions[$name])) {
			$region = $this->regions[$name];
			
			foreach ($this->params as $key => $value) {
				if (strpos($region, "{$key}") !== false){
				
					//if ($value === null)
					//	_warning("Parametr '$key' in region '$name' not definded");
				
					$region = str_replace("{".$key."}", $value, $region);
				}
			}
			
			echo $region;
		}
		return false;
	}
	
	public function SetParam($name, $value)
	{
		$this->params[$name] = $value;
	}
	
	public function GetParam($name)
	{
		return (isset($this->params[$name])) ? $this->params[$name] : null;
	}
}

////////////////////////////////////////////////////////////////////////

abstract class Theme {

	private $___data = array();

	public $__app = false;
	public $path = false;
	public $url = false;
	
	public function __construct($app, $path, $url)
	{
		$this->__app = $app;
		$this->path = $path;
		$this->url = $url;
	}

	public function __set($name, $value) 
	{
		$this->___data[$name] = $value;
	}

	public function __get($name) 
	{
		if (array_key_exists($name, $this->___data)) {
			return $this->___data[$name];
		}

		_error("Undefined property ". $name);
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
		
	public function GetTemplate($name)
	{
		$fileName = $this->path."/templates/$name.php";
		return new Template($fileName, $this->url);
	}
	
	public function Draw($name, $template)
	{		
		
		if (!empty($template)) {
			$head = $template->GetRegion("head");
			$contentBegin = $template->GetRegion("content_begin");
			$contentEnd = $template->GetRegion("content_end");
			$footer = $template->GetRegion("footer");			
	
			if (empty($head) || empty($contentBegin) || empty($contentEnd) || empty($footer)) {
				_error("Template '".$template->Name()."' not have default format");
				return false;
			}
			
			$fileName = "";
			
			if (!empty($name))
				$fileName = $this->__app->path."/pages/$name.page.php";
			else return false;
			
			if (!file_exists($fileName))
				return false;
			
			$title = $this->title;
			if (!empty($title)) {
				$title = "<title>".$title."</title>";
			}
			
			$template->SetParam("title", $title);
			
			$template->DrawRegion("head");
			$template->DrawRegion("content_begin");
			include($fileName);
			$template->DrawRegion("content_end");
			$template->DrawRegion("footer");
			
		}
		else {
			$fileName = "";
			
			if (!empty($name))
				$fileName = $this->__app->path."/pages/$name.page.php";
			else return false;
			
			if (!file_exists($fileName))
				return false;

			include($fileName);
		}
		
		return true;
	}
}

////////////////////////////////////////////////////////////////////////

class Themes {
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
			$path = PATH_THEME.strtolower("/$name");
			$url = str_replace(PATH_SITE, "", PATH_THEME.strtolower("/$name"));
			
			$theme = new $className($app, $path, $url);
			//$theme->app = $app;
			//$theme->path = PATH_THEME.strtolower("/$name");
			//$theme->url = str_replace(PATH_SITE, "", PATH_THEME.strtolower("/$name"));
		}
		else
			return false;
		
		return $theme;
	}
}
?>