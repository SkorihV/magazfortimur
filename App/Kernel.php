<?php

namespace App;

use App\Config\Config;
use App\Router\Dispatcher;
use Smarty;

class Kernel
{
    private $di;

    public function __construct()
    {
        $di = new Di\Container();
        $this->di = $di;

        $di->singletone(Config::class, function (){
            $configDir = 'config';
            return Config::create($configDir);
        });

        /**
         * @var $config Config
         */
       $config = $di->get(Config::class);
        $di->singletone(Smarty::class, function ($di){
            $smarty = new Smarty();
            $config = $di->get(Config::class);

            $smarty->template_dir = $config->renderer->templateDir;
            $smarty->compile_dir = $config->renderer->compileDir;
//            $smarty->cache_dir = APP_DIR . '/var/cache';
//            $smarty->config_dir = APP_DIR . '/var/configs';

            return $smarty;
        });

        foreach ($config->di->singletones as $classname) {
            $di->singletone($classname);
       }
    }

    public function run()
    {
        (new Dispatcher($this->di))->dispatch();
    }
    
    
}