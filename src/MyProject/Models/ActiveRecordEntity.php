<?php

namespace MyProject\Models;

use MyProject\Services\Db;

abstract class ActiveRecordEntity
{
    /** @var int*/
    protected $id;

    /**
    * @return int
    */
    public function getId(): int
    {
        return $this->id;
    }

    /**
    * @param string $name
    * @param string $value
    */
    public function __set(string $name, string $value): void
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    /**
    * @param string $source
    * @return string
    */
    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    /**
     * @return array
     */
    public static function findAll(): array
    {   
        /** @var Db $db */
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName() . ';', [], static::class);
    }

    /**
     * @param int $id
     * @return ActiveRecordEntity
     */
    public static function getById(int $id): ?self
    {
        /** @var Db $db */
        $db = Db::getInstance();

        $entities = $db->query(
                'SELECT * FROM ' . static::getTableName() . ' WHERE id=:id;',
                [':id' => $id],
                static::class
        );
        return $entities ? $entities[0] : null;
    }

    /**
     */
    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    /**
     * @param array $mappedProperties
     */
    public function insert(array $mappedProperties): void
    {
	/* @var array $filteredProperties*/
        $filteredProperties = array_filter($mappedProperties);
        /* @var array $columns*/
        $columns = [];
        foreach ($filteredProperties as $columnName => $value) {
		$columns[] = '' . $columnName. '';
		$paramName = ':' . $columnName;
		$paramsNames[] = $paramName;
		$params2values[$paramName] = $value;
	}
    
	/* @var string $columnsViaSemicolon*/
	$columnsViaSemicolon = implode(', ', $columns);
	/* @var string $paramsNamesViaSemicolon*/
	$paramsNamesViaSemicolon = implode(', ', $paramsNames);

	/* @var string $sql*/
	$sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';
        
	/* @var Db $db*/
	$db = Db::getInstance();
	$db->query($sql, $params2values, static::class);
	$this->id = $db->getLastInsertId();

    }


    /**
     * @param array $mappedProperties
     */
    private function update(array $mappedProperties): void
    {
        /* @var array $columns2params*/
	$columns2params = [];
	/* @var array $params2values*/
	$params2values = [];
	/* @var int $index*/
        $index = 1;
	foreach ($mappedProperties as $column => $value) {
	    /* @var string $param*/
            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1]
            $index++;
	}
	/*@var string $sql*/
	$sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;
	/*@var Db $db*/
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    /**
     * return array
     */
    private function mapPropertiesToDbFormat(): array
    {
        /* @var \ReflectionObject $reflector*/
	    $reflector = new \ReflectionObject($this);
	/* @var array $properties*/
	$properties = $reflector->getProperties();

        /* @var array $mappedProperties*/
	$mappedProperties = [];
	foreach ($properties as $property) {
            /* @var string $propertyName*/
	    $propertyName = $property->getName();
	    /* @var string $propertyNameAsUnderscore*/
	    $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
	    $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
	}
	return $mappedProperties;
    }

    /**
     *
     */
    public function delete(): void
    {
        $db = Db::getInstance();
	$db->query(
	    'DELETE FROM ' . static::getTableName() . ' WHERE id = :id', [':id' => $this->id]);
	$this->id = null;
    }



    abstract protected static function getTableName(): string;

    /**
     * @var string $source
     * @return string
     */
    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }
}
