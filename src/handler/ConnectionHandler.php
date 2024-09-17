<?php

namespace kante\fluffylib\handler;

use kante\fluffylib\ConnectionStorage;
use kante\fluffylib\logger\FluffyLogger;

class ConnectionHandler {

    public function __construct(private ConnectionStorage $storage){}

    public function createTable(string $table, array $columns): void {
        $columns = implode(", ", $columns);

        try {
            $statement = $this->storage->getConnection()->prepare("CREATE TABLE IF NOT EXISTS $table ($columns)");
            $statement->execute();

            FluffyLogger::success("Table $table created successfully");
        } catch (\Exception $e) {
            FluffyLogger::error("Error creating table $table: ".$e->getMessage());
            exit;
        }
    }

    public function dropTable(string $table): void {
        try {
            $statement = $this->storage->getConnection()->prepare("DROP TABLE $table");
            $statement->execute();

            FluffyLogger::success("Table $table dropped successfully");
        } catch (\Exception $e) {
            FluffyLogger::error("Error dropping table $table: ".$e->getMessage());
            exit;
        }
    }

    public function insert(string $table, array $columns, array $values): void {
        try {
            $columns = implode(", ", $columns);
            $placeholders = implode(", ", array_fill(0, count($values), "?"));

            $statement = $this->storage->getConnection()->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
            $statement->execute($values);

            FluffyLogger::success("Data inserted successfully");
        } catch (\Exception $e) {
            FluffyLogger::error("Error inserting data: ".$e->getMessage());
            exit;
        }
    }

}