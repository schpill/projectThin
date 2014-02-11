<?php
    $route = new Route;
    $route->setName('test');
    $route->setPath('test');
    $action = function ($view) {
        $view->variable = time();
    };
    $route->setAction($action);
    $route->setRender('test');
    container()->route($route);
