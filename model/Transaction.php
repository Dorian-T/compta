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
	private ?DateTime $bankingDate;

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
	private ?Category $category;
	

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
	public function __construct(int $id, DateTime $date, DateTime $bankingDate = null, string $description, float $amount, BankAccount $bankAccount, PaymentMethod $paymentMethod, Frequency $frequency, Category $category = null) {
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
	public function getBankingDate(): ?DateTime {
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


	// === Static Methods ===

	/**
	 * Creates a new transaction.
	 *
	 * @param DateTime $date The date of the transaction.
	 * @param DateTime $bankingDate The banking date of the transaction.
	 * @param string $description The description of the transaction.
	 * @param float $amount The amount of the transaction.
	 * @param BankAccount $bankAccount The bank account of the transaction.
	 * @param PaymentMethod $paymentMethod The payment method of the transaction.
	 * @param Frequency $frequency The frequency of the transaction.
	 * @param Category $category The category of the transaction.
	 */
	public static function store(DateTime $date, DateTime $bankingDate = null, string $description, float $amount, BankAccount $bankAccount, PaymentMethod $paymentMethod, Frequency $frequency, Category $category = null): bool {
		if($amount == 0)
			throw new InvalidArgumentException('Amount cannot be 0.');
		elseif($category !== null && $amount < 0 && $category->getType())
			throw new InvalidArgumentException('Income cannot be negative.');
		elseif($category !== null && $amount > 0 && !$category->getType())
			throw new InvalidArgumentException('Expense cannot be positive.');

		$database = new DatabaseConnection();
		return $database->execute(
			'INSERT INTO transactions (date, banking_date, description, amount, bank_account, payment_method, frequency, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
			[
				$date->format('Y-m-d'),
				empty($bankingDate) ? null : $bankingDate->format('Y-m-d'),
				$description,
				$amount,
				$bankAccount->getId(),
				$paymentMethod->getId(),
				$frequency->getId(),
				empty($category) ? null : $category->getId()
			]
		) !== null;
	}

	/**
	 * Gets the 10 last transactions.
	 *
	 * @param int $limit The number of transactions to get.
	 *
	 * @return array An array of Transaction objects.
	 */
	public static function getLastTransactions(): array {
		$database = new DatabaseConnection();
		$transactions = $database->execute('SELECT * FROM transactions ORDER BY date DESC LIMIT 10');
		$objects = [];

		foreach($transactions as $transaction) {
			$objects[] = new Transaction(
				$transaction['id'],
				new DateTime($transaction['date']),
				empty($transaction['banking_date']) ? null : new DateTime($transaction['banking_date']),
				$transaction['description'],
				$transaction['amount'],
				BankAccount::getById($transaction['bank_account']),
				PaymentMethod::getById($transaction['payment_method']),
				Frequency::getById($transaction['frequency']),
				empty($transaction['category']) ? null : Category::getById($transaction['category'])
			);
		}

		return $objects;
	}
}
