<?php

/**
 * Represents an expense or income category for a transaction.
 */
class Category {
	
	// === Properties ===

	/**
	 * The id of the category.
	 */
	private int $id;

	/**
	 * The name of the category.
	 */
	private string $name;

	/**
	 * The type of the category.
	 * 0 for expense, 1 for income.
	 */
	private bool $type;


	// === Constructor ===

	/**
	 * Constructor for the Category class.
	 *
	 * @param int $id The id of the category.
	 * @param string $name The name of the category.
	 * @param bool $type The type of the category.
	 *
	 * @throws InvalidArgumentException If the type is not 0 or 1.
	 */
	public function __construct(int $id, string $name, int $type) {
		$this->id = $id;
		$this->name = $name;
		if($type === 0)
			$this->type = false;
		elseif($type === 1)
			$this->type = true;
		else
			throw new InvalidArgumentException('Invalid type for category.');
	}


	// === Getters ===

	/**
	 * Getter for the id property.
	 *
	 * @return int The id of the category.
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * Getter for the name property.
	 *
	 * @return string The name of the category.
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * Getter for the type property.
	 *
	 * @return bool The type of the category.
	 */
	public function getType(): bool {
		return $this->type;
	}


	// === Static Methods ===

	/**
	 * Gets all the categories from the database.
	 *
	 * @return array An array of categories.
	 */
	public static function getAll(): array {
		$database = new DatabaseConnection();
		$categories = $database->execute('SELECT * FROM categories');
		$objects = [];

		foreach($categories as $category)
			$objects[] = new Category($category['id'], $category['name'], $category['type']);

		return $objects;
	}

	/**
	 * Gets a category by its id.
	 *
	 * @param int $id The id of the category.
	 *
	 * @return Category The category with the given id.
	 */
	public static function getById(int $id): Category {
		$database = new DatabaseConnection();
		$category = $database->execute('SELECT * FROM categories WHERE id = ?', [$id])[0];

		return new Category($category['id'], $category['name'], $category['type']);
	}
}
