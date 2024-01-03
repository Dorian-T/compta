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

	/**
	 * Retrieves all transactions from the database with the following fields:
	 * - transaction_date
	 * - banking_date
	 * - description
	 * - amount
	 * - account
	 * The transactions are sorted by transaction_date in descending order.
	 *
	 * @return array An array of transactions.
	 */
	public function getAllTransactions(): array {
		$sql = 'SELECT transaction_date, banking_date, description, amount, account
				FROM `transactions`
				ORDER BY `transaction_date` DESC';
		$req = self::$db->prepare($sql);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}
}
