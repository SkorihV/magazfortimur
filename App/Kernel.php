<?php

namespace App;

use App\Di\Container;

class Kernel
{
    /**
     * @var Container
     */
    private $container;

    private $config;

    public function __construct()
    {
        $configDir = __DIR__ . '/../config';
        $config = new Config\Config();
        $config->parse($configDir);
    }

    public function run()
    {
        
    }
    
    
}