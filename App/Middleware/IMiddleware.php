<?php

namespace App\AuthMiddleware;

interface IMiddleware
{
    public function beforeDispatch();
    public function afterDispatch();
}