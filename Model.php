<?php

namespace App;

class Model
{

    private  $builder;

    protected $table;

    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->builder = new Builder($this);
    }

    public function __get($name)
    {
        return property_exists($this,$name) ? $this->$name : null;
    }

    public static function __callStatic($method, $arguments)
    {
        return (new static())->$method(...$arguments);
    }

    public function __call($method, $arguments)
    {
        if (method_exists(Builder::class, $method)){
            return $this->builder->$method(...$arguments);
        }
        throw new \BadMethodCallException();
    }

}
