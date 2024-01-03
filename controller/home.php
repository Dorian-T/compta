<?php

class HomeController {
	private $model;

	public $test;

	public function __construct() {
		$this->model = new Model();
	}

	public function render() {
		$transactions = $this->model->getAllTransactions();

		require_once 'view/home.php';
	}
}
