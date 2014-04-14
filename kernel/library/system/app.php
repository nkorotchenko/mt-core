<?php
abstract class Application {
	public $path = false;
	public $url = false;
	abstract public function main ($args, $params);
}
?>