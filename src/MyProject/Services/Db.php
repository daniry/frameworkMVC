<?php

namespace MyProject\Services;
use MyProject\Exceptions\DbException;

class Db
{

    // статическое свойство, в котором будет храниться созданный объект
    private static $instance;

    private $pdo;

    private function __construct() {
        $dboptions = (require __DIR__ . '/../../settings.php')['db'];

        try {
            $this->pdo = new \PDO(
                'mysql:host=' . $dboptions['host'] . ';dbname=' . $dboptions['dbname'],
                $dboptions['user'],
                $dboptions['password']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException('Ошибка при подключении к базе данных: ' . $e->getMessage());
        }
    }

    public function query(string $sql, $params =[], string $className = 'stdClass') {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if($result === false) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    // публичный статический метод, который будет возвращать значение этого счётчика
//    public static function getInstancesCount(): int {
//        return self::$instancesCount;
//    }

    public static function getInstance() {
        // Если равно null, будет создан новый объект класса Db, а затем помещён в это свойство
        if (self::$instance === null) self::$instance = new self();

        return self::$instance;
    }

}