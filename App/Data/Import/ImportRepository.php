<?php

namespace App\Data\Import;

class ImportRepository
{
    public function getFirstLineArray($path)
    {
        $handle = fopen("$path", "r");

        if ($handle) {
            $line = fgets($handle);
            $hendlers = explode(',', $line);
        }

        return  $hendlers;
    }

    public function getNames(array $arrayNames)
    {
        $arrayNamesColumns = [];
        foreach ($arrayNames as $arrayName) {
            $index = strpos( $arrayName, ':');

            $arrayNamesColumns[] = trim(substr($arrayName, 0, $index));
        }
        return $arrayNamesColumns;
    }
}