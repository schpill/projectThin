<?php
    namespace Thin;

    /* CONFIG FILES */
    require_once 'config/ini.php';
    require_once 'config/db.php';
    require_once 'config/data.php';

    /* SITE CONFIGS */
    $conf = array();
    $dbTest = new database();
    $dbTest->setUsername('root')->setPassword('root')->setAdapter('mysql')->setDatabase('test')->setHost('localhost');
    $conf['test'] = $dbTest;
    configs()->setDb($conf);

    /* SITE OPTIONS */
    options()->setDefaultLanguage('fr');

    /* CONTROLLERS */

    /* 404 */
    $page404   = new Route;
    $action = function ($view) {
        $view->title    = 'Page introuvable';
        $view->content  = 'La page que vous cherchez n\'existe pas!';
    };
    $page404->setName(404)->setPath('404')->setAction($action)->setRender('404');
    container()->route($page404);

    /* HOME */
    $home   = new Route;
    $action = function ($view) {
        $view->title    = 'Accueil';
        $view->content  = 'Bienvenue sur la page d\'accueil du site!';
    };
    $home->setName('home')->setPath('')->setAction($action)->setRender('home');
    container()->route($home);
