<?php

namespace App\Controller;

use App\Renderer;
use App\Router\Route;

/**
 * Необходим для вызова шаблонов смарти и их отрисовки с передачей параметров
 */
abstract class AbstractController
{
    /**
     * @var Renderer
     */
    protected Renderer $renderer;

    /**
     * @var Route
     */
    protected Route $route;

    public function render(string $template, array $data = [])
    {
        $smarty = Renderer::getSmarty();

        foreach ($data as $key => $value) {
            $smarty->assign($key, $value);
        }

        return $smarty->display($template);
    }

    public function redirect(string  $url) {

    }
}