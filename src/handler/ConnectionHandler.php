<?php

namespace kante\fluffylib\handler;

use kante\fluffylib\ConnectionStorage;
use kante\fluffylib\logger\FluffyLogger;

class ConnectionHandler {

    public function __construct(private ConnectionStorage $storage){}

    public function createTable(string $table, array $columns): void {
        $columns = implode(", ", $columns);

        $this->execute("CREATE TABLE IF NOT EXISTS $table ($columns)");
        FluffyLogger::success("table $table created successfully");
    }

    public function dropTable(string $table): void {
        $this->execute("DROP TABLE IF NOT EXISTS $table");
        FluffyLogger::success("table $table dropped successfully");
    }

    public function insert(string $table, array $columns, array $values): void {
        $columns = implode(", ", $columns);
        $placeholders = implode(", ", array_fill(0, count($values), "?"));

        $this->execute("INSERT INTO $table ($columns) VALUES ($placeholders)", $values);
        FluffyLogger::success("data inserted successfully");
    }

    public function select(string $table, array $columns, array $conditions = [], array $values = []): array {
        $columns = implode(", ", $columns);

        $query = "SELECT $columns FROM $table";

        if(!empty($conditions)){
            $conditions = implode(" AND ", $conditions);
            $query .= " WHERE $conditions";
        }

        FluffyLogger::success("selecting data from $table successfully");
        return $this->executeFetchAll($query, $values);
    }

    public function execute(string $query, array $values = []): void {
        try {
            $statement = $this->storage->getConnection()->prepare($query);
            $statement->execute($values);
        } catch (\Exception $e) {
            FluffyLogger::error("Error executing query: ".$e->getMessage());
        }
    }

    public function executeFetchAll(string $query, array $values = []): array {
        try {
            $statement = $this->storage->getConnection()->prepare($query);
            $statement->execute($values);
            return $statement->fetchAll();
        } catch (\Exception $e) {
            FluffyLogger::error("Error executing query: ".$e->getMessage());
        }
    }

}