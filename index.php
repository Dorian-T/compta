<?php

session_start();

require_once 'model/model.php';

require_once 'controller/home.php';

if(isset($_GET['action'])) {
	switch($_GET['action']) {
		case 'test':
			echo 'test';
			break;

		default:
			header('Location: ./');
			break;
	}
}
else {
	$controller = new HomeController();
	$controller->render();
}
