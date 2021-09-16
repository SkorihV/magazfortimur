<?php

namespace App\Controller;

use App\Di\Container;
use App\Http\Request;
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
    protected $renderer;

    /**
     * @var Route
     * @onInit(App\Router\Route)
     */
    protected Route $route;

    /**
     * @var Response
     * @onInit(App\Http\Response)
     */
    protected Response $response;


    /**
     * @var Request
    * @onInit(App\Http\Request)
     */
    protected Request $request;

    /**
     * @var Container
     * $onInit(App\DI\Container)
     */
    protected $di;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->route = new Route($this->getRequest());
       // $this->renderer = Renderer::getSmarty();
    }

    public function render(string $template, array $data = [])
    {
        $body = $this->renderer->render($template, $data);

        $this->response->setBody($body);

        return $this->response;
        //     return $this->renderer->render($template, $data);
    }

    public function redirect(string  $url) {

        return $this->response->setRedirectUrl($url);
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}