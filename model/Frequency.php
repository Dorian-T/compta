<?php

/**
 * Represents a frequency for a transaction.
 */
class Frequency {
	
	// === Properties ===

	/**
	 * The id of the frequency.
	 */
	private int $id;

	/**
	 * The name of the frequency.
	 */
	private string $name;


	// === Constructor ===

	/**
	 * Constructor for the Frequency class.
	 *
	 * @param int $id The id of the frequency.
	 * @param string $name The name of the frequency.
	 */
	public function __construct(int $id, string $name) {
		$this->id = $id;
		$this->name = $name;
	}


	// === Getters ===

	/**
	 * Getter for the id property.
	 *
	 * @return int The id of the frequency.
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * Getter for the name property.
	 *
	 * @return string The name of the frequency.
	 */
	public function getName(): string {
		return $this->name;
	}


	// === Static Methods ===

	/**
	 * Gets all the frequencies from the database.
	 *
	 * @return array The frequencies from the database.
	 */
	public static function getAll(): array {
		$database = new DatabaseConnection();
		$frequencies = $database->execute('SELECT * FROM frequencies');
		$allFrequencies = [];

		foreach ($frequencies as $frequency)
			$allFrequencies[] = new Frequency($frequency['id'], $frequency['name']);

		return $allFrequencies;
	}

	/**
	 * Gets a frequency by its id.
	 *
	 * @param int $id The id of the frequency.
	 *
	 * @return Frequency The frequency with the given id.
	 */
	public static function getById(int $id): Frequency {
		$database = new DatabaseConnection();
		$frequency = $database->execute('SELECT * FROM frequencies WHERE id = ?', [$id])[0];

		return new Frequency($frequency['id'], $frequency['name']);
	}
}
