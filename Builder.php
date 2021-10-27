<?php

namespace App;

class Builder
{
    private $conditions = [];
    private $args = [];
    private $model;
    private $sql;
    private $conditionCounter = 0;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function where($column, $operator, $value)
    {
        $this->conditions[$this->conditionCounter] = implode(' ', [$column, $operator, "?"]);
        $this->args[$this->conditionCounter] = $value;
        $this->conditionCounter++;
        return $this;
    }

    public function get($id)
    {
        return $this->where($this->model->primaryKey, '=', $id)->fetch();
    }

    public function toSql()
    {
        $this->sql = "select * from " . $this->model->table;
        $this->compileWhere();
    }

    public function dd()
    {
        $this->toSql();
        echo "<pre>";
        var_dump(['query' => $this->sql, 'arguments' => $this->args]);
        die();

    }

    public function fetch()
    {
        $stmt = $this->executeSql();
        $result = $stmt->fetchObject(get_class($this->model));
        return $result ? $result : null;
    }

    public function fetchAll()
    {
        $stmt = $this->executeSql();
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, get_class($this->model));
        return $result ? $result : null;
    }

    private function compileWhere()
    {
        if (count($this->conditions)) {
            $this->sql .= " where " . $this->conditions[0];
            foreach ($this->conditions as $key => $value) {
                if (!$key) continue;
                $this->sql .= " and " . $value;
            }
        }
    }


    private function executeSql()
    {
        $this->toSql();
        return $this->getDbConnection()->execute($this->sql, $this->args);
    }


    private function getDbConnection()
    {
        return Database::getInstance();
    }
}