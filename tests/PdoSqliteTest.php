<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PdoSqliteTest extends TestCase {
    public function testBasics(): void {
        $this->assertTrue(class_exists(PdoSqlite::class));
        $this->assertContains(PDO::class, class_parents(PdoSqlite::class));
    }

    public static function pdoClassConstantKeysDataProvider(): Generator {
        $reflector = new ReflectionClass(PDO::class);
        $constants = $reflector->getConstants(ReflectionClassConstant::IS_PUBLIC);

        foreach ($constants as $constant => $value) {
            if (str_starts_with($constant, 'SQLITE_')) {
                $sqliteConstant = preg_replace('/^SQLITE_/', '', $constant);
                yield $sqliteConstant => [$constant, $sqliteConstant];
            }
        }
    }

    #[DataProvider('pdoClassConstantKeysDataProvider')]
    public function testPdoConstantsSameAsPdoSqlite(string $constant, string $sqliteConstant): void {
        $this->assertTrue(defined(PdoSqlite::class . '::' . $sqliteConstant), 'Check if PdoSqlite::' . $sqliteConstant . ' exists');
        $this->assertSame(constant('PDO::' . $constant), constant(PdoSqlite::class . '::' . $sqliteConstant), 'Check if value and type PDO::' . $constant . ' === ' . PdoSqlite::class . '::' . $sqliteConstant);
    }

    public function testThrowsOnDifferentDsns(): void {
        if (!in_array('mysql', PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('mysql driver not available');
        }

        $this->expectException(PDOException::class);
        $this->expectExceptionMessage('PdoSqlite::connect() cannot be called when connecting to the "mysql" driver, either PdoMysql::connect() or PDO::connect() must be called instead');
        PdoSqlite::connect('mysql:test');
    }

    public function testThrowsOnUnknownDsns(): void {
        $this->expectException(PDOException::class);
        $this->expectExceptionMessage('could not find driver');
        PdoSqlite::connect('foobar:test');
    }

    public function testConnectionFailures(): void {
        $this->expectException(PDOException::class);
        PdoSqlite::connect('sqlite@:');
    }

    public function testConnectionSuccess(): void {
        $connection = new PdoSqlite('sqlite:');
        $this->assertInstanceOf(PdoSqlite::class, $connection);

        $connection = PdoSqlite::connect('sqlite:');
        $this->assertInstanceOf(PdoSqlite::class, $connection);
    }

    #[DataProvider('pdoClassMethodListProvider')]
    public function testClassMethods(PdoSqlite $sqlite, string $method, array $params): void {
        $this->assertTrue(method_exists($sqlite, $method));

        $reflector = new ReflectionClass($sqlite);
        $method = $reflector->getMethod($method);
        $paramList = $method->getParameters();
        $list = [];
        foreach ($paramList as $param) {
            $list[] = $param->getName();
        }
        $this->assertSame($params, $list);
    }

    public static function pdoClassMethodListProvider(): array {
        $connection = new PdoSqlite('sqlite:');
        return [
            'createAggregate' => [$connection, 'createAggregate', ['name', 'step', 'finalize', 'numArgs']],
            'createCollation' => [$connection, 'createCollation', ['name', 'callback']],
            'loadExtension' => [$connection, 'loadExtension', ['name']],
            'openBlob' => [$connection, 'openBlob', ['table', 'column', 'rowid', 'dbname', 'flags']],
        ];
    }

}
