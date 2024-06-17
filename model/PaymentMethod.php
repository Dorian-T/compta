<?php

/**
 * Represents a payment method for a transaction.
 */
class PaymentMethod {
	
	// === Properties ===

	/**
	 * The id of the payment method.
	 */
	private int $id;

	/**
	 * The name of the payment method.
	 */
	private string $name;


	// === Constructor ===

	/**
	 * Constructor for the PaymentMethod class.
	 *
	 * @param int $id The id of the payment method.
	 * @param string $name The name of the payment method.
	 */
	public function __construct(int $id, string $name) {
		$this->id = $id;
		$this->name = $name;
	}


	// === Getters ===

	/**
	 * Getter for the id property.
	 *
	 * @return int The id of the payment method.
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * Getter for the name property.
	 *
	 * @return string The name of the payment method.
	 */
	public function getName(): string {
		return $this->name;
	}


	// === Static Methods ===

	/**
	 * Gets all the payment methods from the database.
	 *
	 * @return array The payment methods.
	 */
	public static function getAll(): array {
		$database = new DatabaseConnection();
		$paymentMethods = $database->execute('SELECT * FROM payment_methods');
		$paymentMethodsArray = [];

		foreach($paymentMethods as $paymentMethod)
			$paymentMethodsArray[] = new PaymentMethod($paymentMethod['id'], $paymentMethod['name']);

		return $paymentMethodsArray;
	}

	/**
	 * Gets a payment method by its id.
	 *
	 * @param int $id The id of the payment method.
	 *
	 * @return PaymentMethod The payment method.
	 */
	public static function getById(int $id): PaymentMethod {
		$database = new DatabaseConnection();
		$paymentMethod = $database->execute('SELECT * FROM payment_methods WHERE id = ?', [$id])[0];

		return new PaymentMethod($paymentMethod['id'], $paymentMethod['name']);
	}
}
