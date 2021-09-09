<?php

namespace App\Controller;

use App\Http\Response;
use App\Renderer\Renderer;
use App\Router\Route;

/**
 * Необходим для вызова шаблонов смарти и их отрисовки с передачей параметров
 */
abstract class AbstractController
{
    /**
     * @var Renderer
     * @onInit(App\Renderer\Renderer)
     */
    protected Renderer $renderer;

    /**
     * @var Route
     * @onInit(App\Router\Route)
     */
    protected Route $route;

    /**
     * @var Response
     * @onInit(App\Http\Response)
     */
    protected $response;

    public function render(string $template, array $data = [])
    {
//        $smarty = Renderer::getSmarty();
//
//        foreach ($data as $key => $value) {
//            $smarty->assign($key, $value);
//        }
//
//        return $smarty->display($template);

//        echo "<pre>";
//        var_dump($template,$data);
//        echo "</pre>";



echo "<pre>";
echo($this->renderer->render($template, $data));
echo "</pre>";
/*Нормально не работает!*/

       $this->response->setBody($this->renderer->render($template, $data));
        return $this->response;
    }

    public function redirect(string  $url) {
        return $this->response->setRedirectUrl($url);
    }
}