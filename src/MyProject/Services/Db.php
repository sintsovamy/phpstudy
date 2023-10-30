<?php

namespace MyProject\Services;

use MyProject\Exceptions\DbException;

class Db
{
    private \PDO $pdo;
    private static Db $instance;

    private function __construct()
    {

        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];

	try {
                $this->pdo = new \PDO(
                'pgsql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'], $dbOptions['user'], $dbOptions['password']);
	} catch (\PDOException $e) {
            throw new DbException('Ошибка при подключении к базе данных');
	}
    }
                 
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
	}
	return self::$instance;
    }

    /**
     * @return array|null
     */
    public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
	$result = $sth->execute($params);

	if (false === $result) {
            	return null;
	}
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);    
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }

}
