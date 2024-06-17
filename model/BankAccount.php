<?php

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
}
