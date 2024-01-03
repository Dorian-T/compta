<?php

require_once 'model/db_connection.php';

/**
 * Model class.
 */
class Model {
	/**
	 * Database connection.
	 */
	private static $db;

	/**
	 * Constructor for the model class.
	 */
	public function __construct() {
		try {
			self::$db = new PDO('mysql:host='.SERVER.';dbname='.BASE.';charset=utf8', USER, PASSWD);
		} catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}


	// === Homepage ===

	/**
	 * Retrieves all transactions from the database with the following fields:
	 * - transaction_date
	 * - banking_date
	 * - description
	 * - amount
	 * - source_account
	 * The transactions are sorted by transaction_date in descending order.
	 *
	 * @return array An array of transactions.
	 */
	public function getAllTransactions(): array {
		$sql = 'SELECT transaction_date, banking_date, description, amount, source_account
				FROM `transactions`
				ORDER BY `transaction_date` DESC';
		$req = self::$db->prepare($sql);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}


	// === Add transactions ===

	/**
	 * Adds a transaction to the model.
	 *
	 * @param string $bankingDate The banking date of the transaction.
	 * @param string $transactionDate The transaction date of the transaction.
	 * @param string $description The description of the transaction.
	 * @param float $amount The amount of the transaction.
	 * @param string $sourceAccount The source account of the transaction.
	 * @param string $target The target of the transaction.
	 * @param string $payementMethod The payment method of the transaction.
	 * @param string $category The category of the transaction.
	 * @param string $subcategory The subcategory of the transaction.
	 * @return void
	 */
	public function addTransaction($bankingDate, $transactionDate, $description, $amount, $sourceAccount, $target, $paymentMethod, $category, $subcategory): void {
		$sql = 'INSERT INTO `transactions` (banking_date, transaction_date, description, amount, source_account, target, payment_method, category, subcategory)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$req = self::$db->prepare($sql);
		$req->execute([
			$bankingDate,
			$transactionDate ?? null,
			$description,
			$amount,
			$sourceAccount,
			$target ?? null,
			$paymentMethod,
			$category ?? null,
			$subcategory ?? null
		]);
	}

	/**
	 * Retrieves the last 10 transactions from the database with the following fields:
	 * - transaction_date
	 * - banking_date
	 * - description
	 * - amount
	 * - source_account
	 * The transactions are sorted by transaction_date in descending order.
	 *
	 * @return array An array of transactions.
	 */
	public function getLastTransactions(): array {
		$sql = 'SELECT transaction_date, banking_date, description, amount, source_account
				FROM `transactions`
				ORDER BY `transaction_date` DESC
				LIMIT 10';
		$req = self::$db->prepare($sql);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}
}
