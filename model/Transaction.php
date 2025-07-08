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
	public function getCategory(): ?Category {
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
	 * Updates a transaction.
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
	public static function update(int $id, DateTime $date, DateTime $bankingDate = null, string $description, float $amount, BankAccount $bankAccount, PaymentMethod $paymentMethod, Frequency $frequency, Category $category = null): bool {
		if($amount == 0)
			throw new InvalidArgumentException('Amount cannot be 0.');
		elseif($category !== null && $amount < 0 && $category->getType())
			throw new InvalidArgumentException('Income cannot be negative.');
		elseif($category !== null && $amount > 0 && !$category->getType())
			throw new InvalidArgumentException('Expense cannot be positive.');

		$database = new DatabaseConnection();
		return $database->execute(
			'UPDATE transactions SET date = ?, banking_date = ?, description = ?, amount = ?, bank_account = ?, payment_method = ?, frequency = ?, category = ? WHERE id = ?',
			[
				$date->format('Y-m-d'),
				empty($bankingDate) ? null : $bankingDate->format('Y-m-d'),
				$description,
				$amount,
				$bankAccount->getId(),
				$paymentMethod->getId(),
				$frequency->getId(),
				empty($category) ? null : $category->getId(),
				$id
			]
		) !== null;
	}

	/**
	 * Deletes a transaction.
	 *
	 * @param int $id The id of the transaction.
	 */
	public static function destroy(int $id): bool {
		$database = new DatabaseConnection();
		return $database->execute('DELETE FROM transactions WHERE id = ?', [$id]) !== null;
	}

	/**
	 * Gets all transactions ordered by date descending.
	 *
	 * @return array An array of Transaction objects.
	 */
	public static function getAll(): array {
		$database = new DatabaseConnection();
		$transactions = $database->execute('SELECT T.id, T.date, T.banking_date, T.description, T.amount, B.id AS bank_account_id, B.name AS bank_account_name, P.id AS payment_method_id, P.name AS payment_method_name, F.id AS frequency_id, F.name AS frequency_name, C.id AS category_id, C.name AS category_name, C.type AS category_type
											FROM transactions T JOIN bank_accounts B ON T.bank_account = B.id
												JOIN payment_methods P ON T.payment_method = P.id
												JOIN frequencies F ON T.frequency = F.id
												LEFT JOIN categories C ON T.category = C.id
											ORDER BY date DESC, banking_date DESC, description ASC');
		$objects = [];

		foreach($transactions as $transaction) {
			$objects[] = new Transaction(
				$transaction['id'],
				new DateTime($transaction['date']),
				empty($transaction['banking_date']) ? null : new DateTime($transaction['banking_date']),
				$transaction['description'],
				$transaction['amount'],
				new BankAccount($transaction['bank_account_id'], $transaction['bank_account_name']),
				new PaymentMethod($transaction['payment_method_id'], $transaction['payment_method_name']),
				new Frequency($transaction['frequency_id'], $transaction['frequency_name']),
				empty($transaction['category_id']) ? null : new Category($transaction['category_id'], $transaction['category_name'], $transaction['category_type'])
			);
		}

		return $objects;
	}

	/**
	 * Retrieves the transactions by year and month.
	 *
	 * @param int $year The year to filter transactions.
	 * @param int $month The month to filter transactions.
	 * @return array An array of transactions for the specified year and month.
	 */
	public static function getByYearAndMonth(int $year, int $month): array {
		$database = new DatabaseConnection();
		$results = $database->execute('SELECT T.id, T.date, T.banking_date, T.description, T.amount, B.id AS bank_account_id, B.name AS bank_account_name, P.id AS payment_method_id, P.name AS payment_method_name, F.id AS frequency_id, F.name AS frequency_name, C.id AS category_id, C.name AS category_name, C.type AS category_type
										FROM transactions T JOIN bank_accounts B ON T.bank_account = B.id
											JOIN payment_methods P ON T.payment_method = P.id
											JOIN frequencies F ON T.frequency = F.id
											LEFT JOIN categories C ON T.category = C.id
										WHERE YEAR(T.date) = ? AND MONTH(T.date) = ?
										ORDER BY T.date DESC', [$year, $month]);
		$objects = [];

		foreach($results as $transaction) {
			$objects[] = new Transaction(
				$transaction['id'],
				new DateTime($transaction['date']),
				empty($transaction['banking_date']) ? null : new DateTime($transaction['banking_date']),
				$transaction['description'],
				$transaction['amount'],
				new BankAccount($transaction['bank_account_id'], $transaction['bank_account_name']),
				new PaymentMethod($transaction['payment_method_id'], $transaction['payment_method_name']),
				new Frequency($transaction['frequency_id'], $transaction['frequency_name']),
				empty($transaction['category_id']) ? null : new Category($transaction['category_id'], $transaction['category_name'], $transaction['category_type'])
			);
		}

		return $objects;
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
		$transactions = $database->execute('SELECT *
											FROM transactions
											ORDER BY date DESC, banking_date DESC, description ASC
											LIMIT 10');
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

	/**
	 * Retrieves the balance of the transaction group by month.
	 *
	 * @return array The balance of the transaction group by month.
	 */
	public static function getBalances(): array {
		$database = new DatabaseConnection();
		$results = $database->execute('SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(amount) AS total_amount FROM transactions GROUP BY YEAR(date), MONTH(date)');
		$sumsByMonth = [];
		foreach ($results as $result) {
			$key = $result['year'] . '-' . sprintf('%02d', $result['month']); // Format: YYYY-MM
			$sumsByMonth[$key] = $result['total_amount'];
		}
		return $sumsByMonth;
	}

	/**
	 * Retrieves the expenses of the transaction group by month.
	 *
	 * @return array The expenses of the transaction group by month.
	 */
	public static function getExpenses(): array {
		$database = new DatabaseConnection();
		$results = $database->execute('SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(amount) AS total_amount FROM transactions WHERE amount < 0 GROUP BY YEAR(date), MONTH(date)');
		$expensesByMonth = [];
		foreach ($results as $result) {
			$key = $result['year'] . '-' . sprintf('%02d', $result['month']); // Format: YYYY-MM
			$expensesByMonth[$key] = $result['total_amount'];
		}
		return $expensesByMonth;
	}

	/**
	 * Retrieves the incomes of the transaction group by month.
	 *
	 * @return array The incomes of the transaction group by month.
	 */
	public static function getIncomes(): array {
		$database = new DatabaseConnection();
		$results = $database->execute('SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(amount) AS total_amount FROM transactions WHERE amount > 0 GROUP BY YEAR(date), MONTH(date)');
		$incomesByMonth = [];
		foreach ($results as $result) {
			$key = $result['year'] . '-' . sprintf('%02d', $result['month']); // Format: YYYY-MM
			$incomesByMonth[$key] = $result['total_amount'];
		}
		return $incomesByMonth;
	}

	/**
	 * Retrieves the outcomes by frequency.
	 *
	 * @return array The outcomes by frequency.
	 */
	public static function getByFrequency(): array {
		$database = new DatabaseConnection();
		$results = $database->execute('SELECT F.name AS frequency, YEAR(T.date) AS year, MONTH(T.date) AS month, SUM(T.amount) AS total_amount
										FROM transactions T JOIN frequencies F ON T.frequency = F.id
										WHERE T.amount < 0
										GROUP BY F.name, YEAR(T.date), MONTH(T.date)');
		$sumsByFrequency = [];
		foreach ($results as $result) {
			$month = $result['year'] . '-' . sprintf('%02d', $result['month']); // Format: YYYY-MM
			$sumsByFrequency[$result['frequency']][$month] = $result['total_amount'];
		}
		return $sumsByFrequency;
	}

	/**
	 * Retrieves the outcomes by category.
	 *
	 * @return array The outcomes by category.
	 */
	public static function getByCategory(): array {
		$database = new DatabaseConnection();
		$results = $database->execute('SELECT C.name AS category, YEAR(T.date) AS year, MONTH(T.date) AS month, SUM(T.amount) AS total_amount
										FROM transactions T JOIN categories C ON T.category = C.id
										WHERE T.amount < 0
										GROUP BY C.name, YEAR(T.date), MONTH(T.date)');
		$sumsByCategory = [];
		foreach ($results as $result) {
			$month = $result['year'] . '-' . sprintf('%02d', $result['month']); // Format: YYYY-MM
			$sumsByCategory[$result['category']][$month] = $result['total_amount'];
		}
		return $sumsByCategory;
	}

	/**
	 * Retrieves the year of the first transaction.
	 *
	 * @return int The year of the first transaction.
	 */
	public static function getFirstYear(): int {
		$database = new DatabaseConnection();
		$result = $database->execute('SELECT MIN(YEAR(date)) AS first_year FROM transactions');
		return (int) $result[0]['first_year'];
	}
}
