<?php

namespace App\System\Middleware;

use Symfony\Component\HttpFoundation\Request;

class ContentTypeMiddleware implements Middleware
{
    public function __construct(string $controller, string $action, Request $request)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->request = $request;
    }

    public function run(): void
    {
        if ($this->request->headers->get('Content-Type') !== 'application/json') {
            echo json_encode(array('message' => 'Требуется JSON'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit();
        }
    }
}