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
		$rawBalances = Transaction::getBalances();
		$rawIncomes = Transaction::getIncomes();
		$rawExpenses = Transaction::getExpenses();

		// Ensure all months are represented in the balances, incomes, and expenses arrays
		$allMonths = array_unique(array_merge(
			array_keys($rawBalances),
			array_keys($rawIncomes),
			array_keys($rawExpenses)
		));
		sort($allMonths);

		$balances = [];
		$incomes = [];
		$expenses = [];
		foreach ($allMonths as $month) {
			$balances[$month] = isset($rawBalances[$month]) ? $rawBalances[$month] : 0;
			$incomes[$month] = isset($rawIncomes[$month]) ? $rawIncomes[$month] : 0;
			$expenses[$month] = isset($rawExpenses[$month]) ? $rawExpenses[$month] : 0;
		}

		// Frequencies chart
		$transactionsByFrequency = Transaction::getByFrequency();

		// Categories chart
		$transactionsByCategory = Transaction::getByCategory();

		require_once 'view/home.php';
	}
}
