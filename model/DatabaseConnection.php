<?php

require_once 'model/db_connection.php';

/**
 * Represents a bank account for a transaction.
 */
class DatabaseConnection {

	// === Properties ===

	/**
	 * The connection to the database.
	 */
	private PDO $connection;


	// === Constructor ===

	/**
	 * Constructor for the DatabaseConnection class.
	 */
	public function __construct() {
		$this->connection = new PDO('mysql:host=' . SERVER . ';dbname=' . BASE . ';charset=utf8', USER, PASSWD);
	}


	// === Methods ===

	/**
	 * Executes a query on the database.
	 *
	 * @param string $query The query to execute.
	 * @param array $parameters The parameters to bind to the query.
	 * @return array The result of the query.
	 */
	public function execute(string $query, array $parameters = []): array {
		$statement = $this->connection->prepare($query);
		$statement->execute($parameters);
		return $statement->fetchAll();
	}
}
