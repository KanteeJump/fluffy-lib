# fluffy-lib

A simple library for creating databases and handling connections.

## Usage

### Creating a database

```php
<?php

require_once 'vendor/autoload.php';

use kante\fluffylib\ConnectionStorage;
use kante\fluffylib\logger\FluffyLogger;

$storage = new ConnectionStorage("db.sqlite");
$handler = $storage->getHandler();

$handler->createTable("users", 
    ["id INTEGER PRIMARY KEY", "name TEXT", "age INTEGER"]
);

FluffyLogger::info("Database created successfully");
```

### Inserting data

```php
<?php

require_once 'vendor/autoload.php';

use kante\fluffylib\ConnectionStorage;
use kante\fluffylib\logger\FluffyLogger;

$storage = new ConnectionStorage("db.sqlite");
$handler = $storage->getHandler();

$handler->insert("users", ["id", "name", "age"], [1, "Kantee", 25]);

FluffyLogger::info("Data inserted successfully");
```

### Dropping a table

```php
<?php

require_once 'vendor/autoload.php';

use kante\fluffylib\ConnectionStorage;
use kante\fluffylib\logger\FluffyLogger;

$storage = new ConnectionStorage("db.sqlite");
$handler = $storage->getHandler();

$handler->dropTable("users");

FluffyLogger::info("Table dropped successfully");
```

### Selecting data

```php
<?php

require_once 'vendor/autoload.php';

use kante\fluffylib\ConnectionStorage;
use kante\fluffylib\logger\FluffyLogger;

$storage = new ConnectionStorage("db.sqlite");
$handler = $storage->getHandler();

$handler->select("users", ["id", "name", "age"], ["age > ?"], [29]);
$handler->select("users", ["id", "name", "age"], ["id > ?"], [1]);

FluffyLogger::info("Data selected successfully");
```