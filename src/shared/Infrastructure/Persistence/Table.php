<?php


namespace ComputerMonitoring\src\shared\Infrastructure\Persistence;


abstract class Table
{
    private $table_name;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    abstract public function create();

    abstract public function drop();

    public function getTableName(): string
    {
        return $this->table_name;
    }
}