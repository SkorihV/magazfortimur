<?php

namespace App\Config;

use App\Config\Exception\ConfigDirectoryNotFoundException;

class Config
{
    public function parser(string $dirname)
    {
        if (!file_exists($dirname) || !is_dir($dirname)) {
            throw new ConfigDirectoryNotFoundException();
        }
    }

}