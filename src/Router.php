<?php

namespace App;

use App\Services\Redirect;
use App\System\Helpers\SessionHelper;
use Symfony\Component\HttpFoundation\Request;

class Router
{
    private const CONTROLLER = 'c';
    private const ACTION = 'a';
    private const CONTROLLER_TEMPLATE = 'App\\Controllers\\%sController';
    private const API_CONTROLLER_TEMPLATE = 'App\\Controllers\\Api\\%sController';
    private Redirect $redirect;
    private Request $request;

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

        $controller = strtok($data['method'], '.');
        $action = strtok('.');

        $className = $this->getClassName($controller, $action, self::API_CONTROLLER_TEMPLATE);

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
}