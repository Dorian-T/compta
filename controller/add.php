<?php

class AddController extends Controller {
	public function render() {
		if(isset($_POST['submit'])) {
			$this->model->addTransaction(
				$_POST['banking_date'],
				$_POST['transaction_date'],
				$_POST['description'],
				$_POST['amount'],
				$_POST['source_account'],
				$_POST['target'],
				$_POST['payment_method'],
				$_POST['category'],
				$_POST['subcategory']
			);
		}

		$transactions = $this->model->getLastTransactions();

		require_once 'view/add.php';
	}
}
