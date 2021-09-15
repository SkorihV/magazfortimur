<?php

namespace App\AuthMiddleware;

use App\Data\User\UserModel;
use App\Di\Container;
use App\Renderer\Renderer;

class SharedData implements IMiddleware
{

    /**
     * @var Container
     */
    private Container $di;

    /**
     * @param Container $di
     */
    public function __construct(Container $di)
    {

        $this->di = $di;
    }

    public function run()
    {
        /**
         * @var $renderer Renderer
         */
        $renderer = $this->di->get(Renderer::class);


        $user = $this->di->getOrNull(UserModel::class);
        if (!is_null($user)) {
            $renderer->addSharedData('user', $user);
        }
    }
}