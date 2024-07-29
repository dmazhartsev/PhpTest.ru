<?php

namespace App\System\Middleware;

use Symfony\Component\HttpFoundation\Request;

interface Middleware
{
    public function __construct(string $controller, string $action, Request $request);
    public function run();

}