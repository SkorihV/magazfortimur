<?php

namespace App\Config\Exception;

use App\Exception\AbstractAppException;
use Throwable;

class ConfigFileNotFoundExceprion extends AbstractAppException
{
    public function __construct($dirName = "", $code = 500, Throwable $previous = null)
    {
        $message = "Config '$dirName' not found ";
        parent::__construct($message, $code, $previous);
    }
}