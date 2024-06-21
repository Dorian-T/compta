<?php

class BDDController extends Controller {
	public function render() {
		if(isset($_POST['submit'])) {
			if($_POST['submit'] === 'update')
				Transaction::update(
					$_POST['id'],
					new DateTime($_POST['date']),
					empty($_POST['banking_date']) ? null : new DateTime($_POST['banking_date']),
					$_POST['description'],
					$_POST['amount'],
					BankAccount::getById($_POST['bank_account']),
					PaymentMethod::getById($_POST['payment_method']),
					Frequency::getById($_POST['frequency']),
					empty($_POST['category']) ? null : Category::getById($_POST['category'])
				);
			elseif($_POST['submit'] === 'delete')
				Transaction::destroy($_POST['id']);
		}

		$bankAccounts = BankAccount::getAll();
		$paymentMethods = PaymentMethod::getAll();
		$frequencies = Frequency::getAll();
		$categories = Category::getAll();
		$transactions = Transaction::getAll();

		require_once 'view/bdd.php';
	}
}
