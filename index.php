<?php

//////////////////////////////////////////////////////////////
// BOOT

error_reporting (E_ALL | E_STRICT);

if (version_compare(phpversion(), "5.3.0", "<") == true)
	{ die ("PHP 5.3 Only"); }

//запускаю загрузчик
define("PATH_SITE",dirname(__FILE__));
define("PATH_KERNEL",PATH_SITE."/kernel");
define("PATH_THEME",PATH_KERNEL."/theme");
define("PATH_APP",PATH_SITE."/apps");
define("PATH_CONFIG",PATH_KERNEL."/config.php");

require_once(PATH_KERNEL."/startup.php"); 

?>