<?php

namespace App;

use App\Config\Config;
use App\Di\Container;
use App\AuthMiddleware\IMiddleware;
use App\Router\Dispatcher;
use App\Router\Exception\ControllerDoesNotException;
use App\Router\Exception\ExpectToRecieveResponseObjectException;
use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;
use Smarty;

class Kernel
{
    /**
     * @var Di\Container
     */
    private $di;

    public function __construct()
    {
        $di = new Di\Container();
        $this->di = $di;
        $di->addOneMapping(Container::class, $di);

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


            return $smarty;
        });

        foreach ($config->di->singletones as $classname) {
            $di->singletone($classname);
       }
    }


    public function run()
    {
        try {

            $config = $this->di->get(Config::class);

//            foreach ($config->di->middlewares as $classname) {
//
//               $middleware = $this->di->get($classname);
//
//                if ($middleware instanceof IMiddleware) {
//                    $middleware->beforeDispatch();
//
//                }
//            }

//            if(session_start() != PHP_SESSION_ACTIVE) {
//                session_start();
//            }
//            $userId = (int) ($_SESSION['userId'] ?? 0);
//
//            if ($userId) {
//                $user = (new UserRepository())->getById($userId);
//
//                /**
//                 * @var $renderer Renderer
//                 */
//                $renderer = $this->di->get(Renderer::class);
//                $renderer->addSharedData('user', $user);
//            }


            $response =  (new Dispatcher($this->di))->dispatch();






            foreach ($config->di->middlewares as $classname) {
                $middleware = $this->di->get($classname);

                if ($middleware instanceof IMiddleware) {
                    $middleware->afterDispatch();
                }
            }

           echo $response;
        } catch (NotFoundException $e) {
            //404
            echo "404";
        } catch (ControllerDoesNotException | MethodDoesNotExistException $e) {
            //500
            echo "500 роблема с контроллерами или роутерами";
        }  catch (ExpectToRecieveResponseObjectException $e) {
            //500

            echo "500  - response";
        } catch (\ReflectionException $e) {
            //500
            echo "500 - reflection";
        }
    }
    
    
}