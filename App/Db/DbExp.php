<?php

namespace App\Db;

class DbExp
{
    /**
     * @var string
     */
    protected string $value;

    public function __construct( string $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}