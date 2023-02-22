<?php

namespace MyProject\Services;

class Db
{
    // чтобы убедиться в том, что объект действительно создаётся дважды, создадим статическое свойство у класса
    //    private static $instancesCount = 0;

    // статическое свойство, в котором будет храниться созданный объект
    private static $instance;

    private $pdo;

    private function __construct() {
//        self::$instancesCount++;
        $dboptions = (require __DIR__ . '/../../settings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dboptions['host'] . '; dbname=' . $dboptions['dbname'],
            $dboptions['user'],
            $dboptions['password']
        );
        $this->pdo->exec('SET NAMES UTF8');
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