<?php

namespace App\Data\User\Exception;

use App\Exception\AbstractAppException;
use Throwable;

class EmptyFieldException extends AbstractAppException
{
    private array $emptyField = [];


    public function addEmptyField(string $alias)
    {
        $this->emptyField[$alias] = true;
    }

    public function getEmptyFields(): array
    {
        return $this->emptyField;
    }


}