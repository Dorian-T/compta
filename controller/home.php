<?php

/**
 * Class HomeController
 *
 * This class represents the controller for the home page.
 * It extends the base Controller class.
 */
class HomeController extends Controller {
	/**
	 * Renders the home page.
	 */
	public function render() {
		$transactions = $this->model->getAllTransactions();

		require_once 'view/home.php';
	}
}
