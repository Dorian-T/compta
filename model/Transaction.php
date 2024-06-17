<?php

/**
 * Represents a transaction.
 */
class Transaction {
	
	// === Properties ===

	/**
	 * The id of the transaction.
	 */
	private int $id;

	/**
	 * The date of the transaction.
	 */
	private DateTime $date;

	/**
	 * The banking date of the transaction.
	 */
	private DateTime $bankingDate;

	/**
	 * The description of the transaction.
	 */
	private string $description;

	/**
	 * The amount of the transaction.
	 */
	private float $amount;

	/**
	 * The bank account of the transaction.
	 */
	private BankAccount $bankAccount;

	/**
	 * The payment method of the transaction.
	 */
	private PaymentMethod $paymentMethod;

	/**
	 * The frequency of the transaction.
	 */
	private Frequency $frequency;

	/**
	 * The category of the transaction.
	 */
	private Category $category;
	

	// === Constructor ===

	/**
	 * Constructor for the Transaction class.
	 *
	 * @param int $id The id of the transaction.
	 * @param DateTime $date The date of the transaction.
	 * @param DateTime $bankingDate The banking date of the transaction.
	 * @param string $description The description of the transaction.
	 * @param float $amount The amount of the transaction.
	 * @param BankAccount $bankAccount The bank account of the transaction.
	 * @param PaymentMethod $paymentMethod The payment method of the transaction.
	 * @param Frequency $frequency The frequency of the transaction.
	 * @param Category $category The category of the transaction.
	 */
	public function __construct(int $id, DateTime $date, DateTime $bankingDate, string $description, float $amount, BankAccount $bankAccount, PaymentMethod $paymentMethod, Frequency $frequency, Category $category) {
		$this->id = $id;
		$this->date = $date;
		$this->bankingDate = $bankingDate;
		$this->description = $description;
		$this->amount = $amount;
		$this->bankAccount = $bankAccount;
		$this->paymentMethod = $paymentMethod;
		$this->frequency = $frequency;
		$this->category = $category;
	}


	// === Getters ===

	/**
	 * Getter for the id property.
	 *
	 * @return int The id of the transaction.
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * Getter for the date property.
	 *
	 * @return DateTime The date of the transaction.
	 */
	public function getDate(): DateTime {
		return $this->date;
	}

	/**
	 * Getter for the bankingDate property.
	 *
	 * @return DateTime The banking date of the transaction.
	 */
	public function getBankingDate(): DateTime {
		return $this->bankingDate;
	}

	/**
	 * Getter for the description property.
	 *
	 * @return string The description of the transaction.
	 */
	public function getDescription(): string {
		return $this->description;
	}

	/**
	 * Getter for the amount property.
	 *
	 * @return float The amount of the transaction.
	 */
	public function getAmount(): float {
		return $this->amount;
	}

	/**
	 * Getter for the bankAccount property.
	 *
	 * @return BankAccount The bank account of the transaction.
	 */
	public function getBankAccount(): BankAccount {
		return $this->bankAccount;
	}

	/**
	 * Getter for the paymentMethod property.
	 *
	 * @return PaymentMethod The payment method of the transaction.
	 */
	public function getPaymentMethod(): PaymentMethod {
		return $this->paymentMethod;
	}

	/**
	 * Getter for the frequency property.
	 *
	 * @return Frequency The frequency of the transaction.
	 */
	public function getFrequency(): Frequency {
		return $this->frequency;
	}

	/**
	 * Getter for the category property.
	 *
	 * @return Category The category of the transaction.
	 */
	public function getCategory(): Category {
		return $this->category;
	}
}
