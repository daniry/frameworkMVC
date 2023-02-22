<?php

//Этот шаблон говорит о том, что сущность (объекты класса статьи или пользователя) сами должны управлять работой с базой данных.

namespace MyProject\Models;

use MyProject\Services\Db;

// Так как создание объектов этого класса нам не нужно, то делаем его абстрактным
abstract class ActiveRecordEntity
{
    // у всех наших сущностей будет id
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

    // все дочерние сущности будут его иметь
    public function __set($name, $value) {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    // используется внутри метода __set()
    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    //метод, который будет преобразовывать строки типа authorId в author_id.
    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

//    статический метод, возвращающий нам все из таблицы
//    будет доступен во всех классах-наследниках
//    static - позднее статическое связывание - благодаря нему мы можем писать код, который будет зависеть от класса, в котором он вызывается, а не в котором он описан
    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

//    получение названия таблицы
    abstract protected static function getTableName(): string;

//    метод, который будет возвращать одну статью по id
//      Этот метод вернёт либо один объект, если он найдётся в базе, либо null – что будет говорить об его отсутствии.
    public static function getById(int $id) {
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }


    // метод, который прочитает все свойства объекта и создаст массив
    // мы получили все свойства, и затем каждое имяСвойства привели к имя_свойства
    // После чего в массив $mappedProperties мы стали добавлять элементы с ключами «имя_свойства» и со значениями этих свойств
    private function mapPropertiesToDbFormat(): array {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }
        return $mappedProperties;
    }


    // метод save(), который в зависимости от того, есть ли у объекта id, решает – обновить запись или создать новую
    public function save(): void {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    // метод удаления из бд
    public function delete(): void
    {
        $db = Db::getInstance();
        $db->query(
            'DELETE FROM `' . static::getTableName() . '` WHERE id = :id',
            [':id' => $this->id]
        );
        $this->id = null;
    }

    private function update(array $mappedProperties): void
    {
        //здесь мы обновляем существующую запись в базе
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1]
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    private function insert(array $mappedProperties): void
    {
        //здесь мы создаём новую запись в базе
        $mappedPropertiesNotNull = array_filter($mappedProperties);

        $columns = [];
        $params = [];
        $params2values = [];
        $index = 1;

        foreach ($mappedPropertiesNotNull as $column => $value) {
            $params[] = ':param' . $index; // :params
            $columns[] = $column; // columns
            $params2values[':param' . $index] = $value; // [:param => value]
            $index++;
        }

        $sql = 'INSERT INTO ' . static::getTableName() . '(' . implode(', ', $columns) . ') VALUES (' . implode(', ', $params) . ')';

        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

}
