<?php

class PdoSqlite extends PDO {
    public const DETERMINISTIC = PDO::SQLITE_DETERMINISTIC;
    public const OPEN_READONLY = PDO::SQLITE_OPEN_READONLY;

    public const OPEN_READWRITE = PDO::SQLITE_OPEN_READWRITE;

    public const OPEN_CREATE = PDO::SQLITE_OPEN_CREATE;

    public const ATTR_OPEN_FLAGS = PDO::SQLITE_ATTR_OPEN_FLAGS;

    public const ATTR_READONLY_STATEMENT = PDO::SQLITE_ATTR_READONLY_STATEMENT;

    public const ATTR_EXTENDED_RESULT_CODES = PDO::SQLITE_ATTR_EXTENDED_RESULT_CODES;

    public static function connect(
        string $dsn,
        ?string $username = null,
        #[\SensitiveParameter] ?string $password = null,
        ?array $options = null
    ): static {

        if (!preg_match('/^([a-z0-9]+):/', $dsn, $matches)) {
            throw new PDOException('PDO::connect(): Argument #1 ($dsn) must be a valid data source name.');
        }

        if (!in_array($matches[1], PDO::getAvailableDrivers(), true)) {
            throw new PDOException('could not find driver');
        }

        if ($matches[1] !== 'sqlite') {
            throw new PDOException(sprintf('PdoSqlite::connect() cannot be called when connecting to the "%s" driver, either %s::connect() or PDO::connect() must be called instead',
                $matches[1],
                'Pdo' . ucfirst($matches[1]),
            ));
        }

        return new static($dsn, $username, $password, $options);
    }
    public function createAggregate(string $name, callable $step, callable $finalize, int $numArgs = -1): bool {

    }

    public function createCollation(string $name, callable $callback): bool {

    }

    public function createFunction(string $function_name, callable $callback, int $num_args = -1, int $flags = 0): bool {

    }
    public function loadExtension(string $name): void {}

    /** @return resource|false */
    public function openBlob(string $table, string $column, int $rowid, ?string $dbname = "main", int $flags = PdoSqlite::OPEN_READONLY) {

    }
}
