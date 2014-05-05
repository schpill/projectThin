<?php
    namespace Thin;

    /* 500 */
    $page500   = new Route;
    $action = function ($view) {
        header('HTTP/1.0 500 Internal Server Error');
        $view->title    = 'Erreur système';
        $view->content  = 'Cette page comporte des erreurs!';
    };
    $page500->setName(500)->setPath('error')->setAction($action)->setRender('500');
    container()->route($page500);

    /* 404 */
    $page404   = new Route;
    $action = function ($view) {
        header('HTTP/1.0 404 Not Found');
        $view->title    = 'Page introuvable';
        $view->content  = 'La page que vous cherchez n\'existe pas!';
    };
    $page404->setName(404)->setPath('404')->setAction($action)->setRender('404');
    container()->route($page404);
    container()->setNotFoundRoute($page404);

    /* HOME */
    $home   = new Route;
    $action = function ($view) {
        $view->title    = 'Accueil';
        $view->content  = 'Bienvenue sur la page d\'accueil du site!';
    };
    $home->setName('home')->setPath('')->setAction($action)->setRender('home');
    container()->route($home);
