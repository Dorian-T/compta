<?php

require_once 'model/DatabaseConnection.php';


/**
 * Represents a bank account for a transaction.
 */
class BankAccount {

	// === Properties ===

	/**
	 * The id of the bank account.
	 */
	private int $id;

	/**
	 * The name of the bank account.
	 */
	private string $name;


	// === Constructor ===

	/**
	 * Constructor for the BankAccount class.
	 *
	 * @param int $id The id of the bank account.
	 * @param string $name The name of the bank account.
	 */
	public function __construct(int $id, string $name) {
		$this->id = $id;
		$this->name = $name;
	}


	// === Getters ===

	/**
	 * Getter for the id property.
	 *
	 * @return int The id of the bank account.
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * Getter for the name property.
	 *
	 * @return string The name of the bank account.
	 */
	public function getName(): string {
		return $this->name;
	}


	// === Static Methods ===

	/**
	 * Returns all bank accounts.
	 *
	 * @return array An array of BankAccount objects.
	 */
	public static function getAll(): array {
		$database = new DatabaseConnection();
		$accounts = $database->execute('SELECT * FROM bank_accounts');
		$bankAccounts = [];

		foreach($accounts as $account)
			$bankAccounts[] = new BankAccount($account['id'], $account['name']);

		return $bankAccounts;
	}

	/**
	 * Returns a bank account by its id.
	 *
	 * @param int $id The id of the bank account.
	 *
	 * @return BankAccount The bank account.
	 */
	public static function getById(int $id): BankAccount {
		$database = new DatabaseConnection();
		$account = $database->execute('SELECT * FROM bank_accounts WHERE id = ?', [$id])[0];

		return new BankAccount($account['id'], $account['name']);
	}
}
