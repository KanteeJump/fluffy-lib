<?php

namespace kante\fluffylib;

use kante\fluffylib\handler\ConnectionHandler;
use kante\fluffylib\logger\FluffyLogger;
use PDO;

class ConnectionStorage {

    private PDO $connection;

    private ConnectionHandler $handler;

    public function __construct(private string $file){
        if(!file_exists($file)){
            FluffyLogger::error("File not found: ".$file);
            exit;
        }

        $this->connection = new PDO("sqlite:".$file);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $this->handler = new ConnectionHandler($this);
    }

    public function getHandler(): ConnectionHandler {
        return $this->handler;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }

}