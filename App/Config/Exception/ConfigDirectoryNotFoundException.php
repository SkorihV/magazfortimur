<?php

namespace App\Config\Exception;

use App\Exception\AbstractAppException;
use Throwable;

class ConfigDirectoryNotFoundException extends AbstractAppException
{
    public function __construct($dirName = "", $code = 500, Throwable $previous = null)
    {
        $message = "Directory '$dirName' not found";
        parent::__construct($message, $code, $previous);
    }
}