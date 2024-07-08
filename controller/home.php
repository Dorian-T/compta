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
		// Balance table
		$accounts = BankAccount::getAll();

		// Balance chart
		$balances = Transaction::getBalances();
		$incomes = Transaction::getIncomes();
		$expenses = Transaction::getExpenses();

		// Frequencies chart
		$transactionsByFrequency = Transaction::getByFrequency();

		// Categories chart
		$transactionsByCategory = Transaction::getByCategory();

		require_once 'view/home.php';
	}
}
