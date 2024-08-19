<?php

namespace App;

use App\Services\Redirect;
use App\System\Helpers\SessionHelper;
use App\System\Middleware\AuthMiddleware;
use App\System\Middleware\ContentTypeMiddleware;
use Symfony\Component\HttpFoundation\Request;

class Router
{
    private const CONTROLLER = 'c';
    private const ACTION = 'a';
    private const CONTROLLER_TEMPLATE = 'App\\Controllers\\%sController';
    private const API_CONTROLLER_TEMPLATE = 'App\\Controllers\\Api\\%sController';

    private Redirect $redirect;
    private Request $request;
    private string $controllerString;
    private string $actionString;

    public function __construct()
    {
        $this->redirect = new Redirect();
        $this->request = Request::createFromGlobals();
    }

    public function runSite(): void
    {
        $controller = $this->request->query->get(self::CONTROLLER) ?? '';
        $action = $this->request->query->get(self::ACTION) ?? '';

        $this->validateGet($controller, $action);
        $className = $this->getClassName($controller, $action, self::CONTROLLER_TEMPLATE);

        $controller = new $className();
        $controller->setRequest($this->request);
        $controller->$action();
    }

    public function runApi(): void
    {
        $data = $this->request->toArray();

        [$this->controllerString, $this->actionString] = explode('.', $data['method']);

        $this->middleware(AuthMiddleware::class, ContentTypeMiddleware::class);

        $className = $this->getClassName($this->controllerString, $this->actionString, self::API_CONTROLLER_TEMPLATE);

        $action = $this->actionString;
        $controller = new $className();
        $controller->setRequestAndHeaders($data['params']);
        $controller->$action();
    }

    private function validateGet(string $controller, string $action): void
    {
        if (empty($controller) && empty($action)) {
            SessionHelper::getInstance()->hasUserId()
                ? $this->redirect->toInfo()
                : $this->redirect->toAuthorisation();
        }
    }

    private function getClassName(string $controller, string $action, string $controllerTemplate): string
    {
        $className = sprintf($controllerTemplate, $controller);

        if (!class_exists($className) || !method_exists($className, $action)) {
            $this->redirect->to404();
        }

        return $className;
    }

    private function middleware(string ...$middleware): void
    {
        foreach ($middleware as $item) {
            if (!class_exists($item)) {
                $this->redirect->to404();
            }
            $middleware = new $item();
            $middleware->run($this->controllerString, $this->actionString, $this->request);
        }
    }
}