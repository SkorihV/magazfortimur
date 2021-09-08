<?php

namespace App\Http;

class Response
{
    public function redirect(string $url = '/')
    {
        header('Location: ' . $url);
        exit;
    }
}