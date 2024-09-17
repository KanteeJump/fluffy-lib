** FluffyLib **

> A simple library for creating databases and handling connections.

## Installation

> in your composer.json write:

```json
{
    "require": {
        "weed/fluffy-lib": "main"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "git@https://github.com/KanteeJump/fluffy-lib"
        }
    ]
}
```

> run `composer update`

## Usage

### Creating a database

> This will create a database called "YOUR_FILE.sqlite" in the same directory as the script.

```php
<?php

require_once 'vendor/autoload.php';

use kante\fluffylib\ConnectionStorage;

$storage = new ConnectionStorage("YOUR_FILE.sqlite");
$handler = $storage->getHandler();

```

### Creating a table

> This will create a table called "users" with the following columns:

- id: INTEGER PRIMARY KEY AUTOINCREMENT
- name: TEXT NOT NULL
- email: TEXT NOT NULL UNIQUE
- created_at: DATETIME DEFAULT CURRENT_TIMESTAMP

```php
<?php


$handler->createTable('users', [
    'id INTEGER PRIMARY KEY AUTOINCREMENT',
    'name TEXT NOT NULL',
    'email TEXT NOT NULL UNIQUE',
    'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
]);

```

### Inserting data

> This will insert a new user with the following data:

- name: John Doe
- email: john@example.com

```php
<?php

$handler->insert('users', ['name', 'email'], ['John Doe', 'john@example.com']);

```

### Selecting data

> This will select all users with the following conditions:

- id: 1

```php
<?php

$users = $handler->select('users', ['id', 'name', 'email'], ['id='], [1]);
echo "Users:\n";
print_r($users);

```

### Updating data

> This will update the name of the user with the following conditions:

- id: 1

```php
<?php

$handler->update('users', ['name'], ['id='], ['John Updated', 1]);

```

### Deleting data

> This will delete the user with the following conditions:

- id: 1

```php
<?php

$handler->delete('users', ['id='], [1]);

```

### Dropping a table

> This will drop the table "users"

```php
<?php

$handler->dropTable('users');

```

## Copyright

Copyright 2024 [Kantee Jump](https://github.com/KanteeJump/fluffy-lib.git)