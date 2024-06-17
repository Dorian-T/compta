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
}
