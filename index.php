<?php

session_start();

require_once 'model/model.php';

require_once 'controller/controller.php';
require_once 'controller/home.php';
require_once 'controller/add.php';

if(isset($_GET['action'])) {
	switch($_GET['action']) {
		case 'add':
			$add = new AddController();
			$add->render();
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
