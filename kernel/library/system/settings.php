<?php
class Settings
{
	// VARIABLES
	private $container = array();
	
	function __construct()
	{
		$this->container = array(
            "core"   		=> array("install"=>"0", "style"=>"default", "prefix"=>"fc", "site_name"=>""),
            "data_base"   	=> array("pconnect"=>"0", "server"=>"localhost", "name"=>"", "user"=>"root", "password"=>"")
        );
		
		asort($this->container);
    }
	
	function __destruct()
	{
		unset($this->container["core"]);
		unset($this->container["data_base"]);
		unset($this->container);
    }

	public function GetParam($cont, $name)
	{	
		return isset($this->container[$cont][$name])
			? $this->container[$cont][$name] : null;
	}
	
	public function Get($cont)
	{	
		return isset($this->container[$cont])
			? $this->container[$cont] : null;
	}
	
	public function Init()
	{
		if (!file_exists(PATH_CONFIG))
			$this->Save();
		
		$this->Load();
	}
	
	public function Save($fileName = PATH_CONFIG)
	{
		$ini = new IniFile( $fileName );
		
		foreach ($this->container as $containerKey => $containerValue)
		{
			foreach ($containerValue as $key => $val)
			{
				$ini->write($containerKey,$key,$val);
			}
		}
		$ini->updateFile();
	}
	
	public function Load($fileName = PATH_CONFIG)
	{
		$ini = new IniFile( $fileName );		
		
		foreach ($this->container as $containerKey => $containerValue)
		{
			foreach ($containerValue as $key => $val)
			{
				$this->container[$containerKey][$key] = $ini->read($containerKey,$key,$val);
			}
		}
	}
}
?>