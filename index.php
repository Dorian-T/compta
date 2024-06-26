<?php

session_start();

require_once 'database/backups.php';

require_once 'model/BankAccount.php';
require_once 'model/Category.php';
require_once 'model/Frequency.php';
require_once 'model/PaymentMethod.php';
require_once 'model/Transaction.php';

require_once 'model/model.php';

require_once 'controller/controller.php';
require_once 'controller/add.php';
require_once 'controller/bdd.php';
require_once 'controller/home.php';


if(isset($_GET['action'])) {
	switch($_GET['action']) {
		case 'add':
			$add = new AddController();
			$add->render();
			break;

		case 'bdd':
			$bdd = new BDDController();
			$bdd->render();
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
