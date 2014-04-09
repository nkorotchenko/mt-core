<?php
abstract class Application {
	public $path = false;
	abstract public function main ($args, $params);
}
?>