<?php

function UseLibrary($name)
{
	$fileName = PATH_KERNEL."/library/$name/$name.lib.php";
	
	if (file_exists($fileName) == false)
		return false;
		
	require_once($fileName);
	return true;
}

UseLibrary("system");
UseLibrary("security");
UseLibrary("template");

System::Init();
System::RunApp("route");
System::Dispose();

?>