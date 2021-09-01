<?php

namespace App\Router;

use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;

class Route
{
    /**
     * @var string|null
     */
    private $url;

    /**
     * @var string|null
     */
    private $controller = null;

    /**
     * @var string|null
     */
    private $method = null;

    /**
     * @var array
     */
    private $params = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return Route
     */
    public function setUrl(?string $url): Route
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getController(): ?string
    {
        return $this->controller;
    }

    /**
     * @param string|null $controller
     * @return Route
     */
    public function setController(?string $controller): Route
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param string|null $method
     * @return Route
     */
    public function setMethod(?string $method): Route
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     * @throws MethodDoesNotExistException
     * @throws NotFoundException
     */
    public function execute()
    {
        $controllerClass = $this->getController();

        if (is_null($controllerClass)) {
            throw new NotFoundException();
        }

        $controller = new $controllerClass([]);

        $controllerMethod = $this->getMethod();

        if (method_exists($controller, $controllerMethod)) {
            return $controller->{$controllerMethod}();
        }

        throw new MethodDoesNotExistException();
    }

    public function setParam(string $key, $value)
    {
        $this->params[$key] = $value;
        return $this;
    }

    public function getParam(string $key)
    {
        return $this->params[$key] ?? null;
    }
}