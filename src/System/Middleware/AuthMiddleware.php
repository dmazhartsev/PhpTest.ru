<?php

namespace App\System\Middleware;

use App\System\JWT\UserJWT;
use Symfony\Component\HttpFoundation\Request;

class AuthMiddleware implements Middleware
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
        if (($this->controller == 'User' && $this->action == 'authorisation') ||
            ($this->controller == 'User' && $this->action == 'registration')) {
        }

        $tokenString = substr($this->request->headers->get('Authorization') ?? '', 7);

        if (!UserJWT::getInstance()->verifyToken($tokenString)) {
            echo json_encode(array('message' => 'Необходима авторизация'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit();
        }
    }

}