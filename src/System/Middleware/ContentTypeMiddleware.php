<?php

namespace App\System\Middleware;

use Symfony\Component\HttpFoundation\Request;

class ContentTypeMiddleware implements MiddlewareInterface
{
    private string $controller;
    private string $action;
    private Request $request;

    public function __construct(string $controller, string $action, Request $request)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->request = $request;
    }

    public function run(): void
    {
        if ($this->request->headers->get('Content-Type') !== 'application/json') {
            echo json_encode(['message' => 'Требуется JSON'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit();
        }
    }
}