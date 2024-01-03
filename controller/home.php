<?php

class HomeController {
	private $model;

	public function __construct() {
		$this->model = new Model();
	}

	public function display() {
		echo 'Home';
	}
}
