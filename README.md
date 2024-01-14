# PDO Sqlite Subclass Polyfill

[![Latest Stable Version](https://poser.pugx.org/polyfills/pdo-sqlite-subclass/v)](https://packagist.org/packages/polyfills/pdo-sqlite-subclass) [![License](https://poser.pugx.org/polyfills/pdo-sqlite-subclass/license)](https://packagist.org/packages/polyfills/pdo-sqlite-subclass) [![PHP Version Require](https://poser.pugx.org/polyfills/pdo-sqlite-subclass/require/php)](https://packagist.org/packages/polyfills/pdo-sqlite-subclass) ![CI](https://github.com/PHP-Polyfills/PDO-MySQL-Subclass/actions/workflows/ci.yml/badge.svg)

Provides user-land PHP polyfills for the Sqlite subclass provided by PHP 8.4.

Supports PHP 8.1, 8.2, and 8.3. On PHP 8.4 and later, this polyfill is not necessary. Requires `pdo_sqlite` extension.

It is possible and safe to require this polyfill on PHP 8.4 and later. This polyfill class is autoloadable; on PHP 8.4 and later, PHP will _not_ autoload this polyfill because it's declared natively.

For more information, see [`PdoSqlite`](https://php.watch/versions/8.4/pdo-driver-subclasses#PdoSqlite) on [`PHP 8.4: PDO Driver-specific sub-classes: Sqlite`](https://php.watch/versions/8.4/pdo-driver-subclasses)

## Installation

```bash
composer require polyfills/pdo-sqlite-subclass
```

## Usage

Use the provided `PdoMysql` class to replace `PDO` MySQL connections.

```php
$sqliteConnection = new PdoMysql(
    'sqlite:host=localhost;dbname=phpwatch;charset=utf8mb4;port=33066',
    '<username>',
    '<password>',
);
```

```php
$sqliteConnection = PdoMysql::connect(
    'sqlite:host=localhost;dbname=phpwatch;charset=utf8mb4;port=33066',
    '<username>',
    '<password>',
);
```

This polyfill adds class-constants to `PdoSqlite` class to match all of the `PDO::MYSQL_` constants. For example, `PDO::MYSQL_ATTR_SSL_CERT` is identical to `PdoMysql::ATTR_SSL_CERT`.

### Features not implemented

 - `PDO::connect`: This method cannot be polyfilled because it's an existing PHP class that user-land PHP classes cannot modify.

## Contributions

Contributions are welcome either as a GitHub issue or a PR to this repo.

