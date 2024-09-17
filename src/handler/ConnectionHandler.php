<?php

namespace kante\fluffylib\handler;

use Exception;
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
        $this->execute("DROP TABLE IF EXISTS $table");
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

        $query = $this->where($query, $conditions);

        FluffyLogger::success("selecting data from $table successfully");
        return $this->executeFetchAll($query, $values);
    }

    public function update(string $table, array $set, array $conditions = [], array $values = []): void {
        $set = count($set) > 1 ? implode("=?, ", $set) : array_shift($set) . "=?";
        
        $query = "UPDATE $table SET $set";

        $query =$this->where($query, $conditions);

        $this->execute($query, $values);
        FluffyLogger::success("data updated successfully");
    }

    public function delete(string $table, array $conditions = [], array $values = []): void {
        $query = "DELETE FROM $table";

        $query = $this->where($query, $conditions);

        $this->execute($query, $values);
        FluffyLogger::success("data deleted successfully");
    }

    private function where(string $query, array $conditions): string {
        if(!empty($conditions)){
            $conditions = array_map(function($value){
                return "$value?";
            }, $conditions);

            $conditions = implode(" AND ", $conditions);

            $query .= " WHERE $conditions";
        }

        return $query;
    }

    public function execute(string $query, array $values = []): void {
        try {
            $statement = $this->storage->getConnection()->prepare($query);
            $statement->execute($values);
        } catch (Exception $e) {
            throw new Exception("Error executing query: ".$e->getMessage());
        }
    }

    public function executeFetchAll(string $query, array $values = []): array {
        try {
            $statement = $this->storage->getConnection()->prepare($query);
            $statement->execute($values);
            return $statement->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error executing query: ".$e->getMessage());
        }
    }

}