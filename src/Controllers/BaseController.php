<?php

namespace App\Controllers;

use App\Services\Redirect;
use App\System\AppException\AppException;
use App\System\AppException\AppExceptionCode;
use Jenssegers\Blade\Blade;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;

class BaseController
{
    private const CACHE_PATH = __DIR__ . '/../../Cache/';
    private const VIEWS_PATH = __DIR__ . '/../Views/';
    protected InputBag $request;

    /**
     * @throws AppException
     */
    public function setRequest(Request $request): void
    {
        if (isset($this->request)) {
            throw new AppException('Request already set', AppExceptionCode::ERROR_REQUEST_WRITE);
        }

        $this->request = $request->request;
    }
    protected function render(string $viewName, array $params = []): void
    {
        $blade = new Blade([self::VIEWS_PATH], self::CACHE_PATH);
        $viewCatalog = str_replace([__NAMESPACE__, 'Controller', '\\'], '', static::class);
        echo $blade->render($viewCatalog . DIRECTORY_SEPARATOR . $viewName, $params);
    }

    protected function getRedirect(): Redirect
    {
        static $Redirect;

        if ($Redirect === null) {
            $Redirect = new Redirect();
        }

        return $Redirect;
    }
}