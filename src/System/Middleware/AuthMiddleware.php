<?php

namespace App\System\Middleware;

use App\System\JWT\UserJWT;
use Symfony\Component\HttpFoundation\Request;

class AuthMiddleware implements MiddlewareInterface
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
        if (($this->controller === 'User') && (($this->action === 'authorisation') || ($this->action === 'registration'))) {
            return;
        }

        if ($this->request->headers->get('Authorization') === null) {
            echo json_encode(['message' => 'Требуется авторизация'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit();
        }

        $tokenString = str_replace($this->request->headers->get('Authorization') ?? '', '', 'Bearer');

        if (!UserJWT::getInstance()->verifyToken($tokenString)) {
            echo json_encode(['message' => 'Токен недействителен'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit();
        }
    }

}