<?php

namespace MyProject\Models;

use MyProject\Services\Db;

abstract class ActiveRecordEntity
{
    protected int $id;
	
    public function getId(): int
    {
        return $this->id;
    }

    public function __set(string $name, string $value): void
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }
	
    /** returns array of records from static::getTableName() table */
    public static function findAll(): array
    {   
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName() . ';', [], static::class);
    }

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();

        $entities = $db->query(
                'SELECT * FROM ' . static::getTableName() . ' WHERE id=:id;',
                [':id' => $id],
                static::class
        );
        return $entities ? $entities[0] : null;
    }

    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }
	
    /** makes an array of fields for new record */
    public function insert(array $mappedProperties): void
    {
	/** @var array $filteredProperties 
        * is $mappedProperties without null fields*/
        $filteredProperties = array_filter($mappedProperties);
        $columns = [];
        foreach ($filteredProperties as $columnName => $value) {
		$columns[] = '' . $columnName. '';
		$paramName = ':' . $columnName;
		$paramsNames[] = $paramName;
		$params2values[$paramName] = $value;
	}
    
	/** @var string $columnsViaSemicolon
        *of comma separated columns "colunm1, column2, ..." */
	$columnsViaSemicolon = implode(', ', $columns);
	/** @var string $paramsNamesViaSemicolon
        *of comma separated params "param1, param2, ..." */
	$paramsNamesViaSemicolon = implode(', ', $paramsNames);

	$sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';
        
	$db = Db::getInstance();
	$db->query($sql, $params2values, static::class);
	$this->id = $db->getLastInsertId();

    }


    /**
     * array $columns2params of string "column1 = :param1"
     * array $params2values of string "[:param1 => value1]"
     */
    private function update(array $mappedProperties): void
    {
	$columns2params = [];
	$params2values = [];
	/** @var int $index */
        $index = 1;
	foreach ($mappedProperties as $column => $value) {
	    /* @var string $param
            * of ":param1" */
            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1]
            $index++;
	}

	$sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = :param5';
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    /** returns array of string "'property1' => value1, 'property2' => value2, ..." */
    private function mapPropertiesToDbFormat(): array
    {
	$reflector = new \ReflectionObject($this);
        /** @var array $properties of string */
	$properties = $reflector->getProperties();

        /* @var array $mappedProperties of string 
	* properties in camelCaseToUnderscore view*/
	$mappedProperties = [];
	foreach ($properties as $property) {
	    $propertyName = $property->getName();
	    $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
	    $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
	}
	return $mappedProperties;
    }

    public function delete(): void
    {
        $db = Db::getInstance();
	$db->query(
	    'DELETE FROM ' . static::getTableName() . ' WHERE id = :id', [':id' => $this->id]);
	$this->id = null;
    }



    abstract protected static function getTableName(): string;

  
    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }
}
