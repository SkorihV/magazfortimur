<?php

namespace App;

use App\Config\Config;
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
        $di = new Di\Container();
        $di->singletone(Config::class, function (){
            $configDir = 'config';
            return Config::create($configDir);
        });



        /**
         * @var $config Config
         */
       $config = $di->get(Config::class);
        foreach ($config->di->singletones as $classname) {
            echo "<pre>";
            var_dump($classname);
            echo "</pre>";

       }



    }

    public function run()
    {
        
    }
    
    
}