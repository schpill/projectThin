<?php
    namespace Thin;

    ini_set("memory_limit", '512M');

    /* CONFIG FILES */
    require_once 'config/ini.php';
    require_once 'config/db.php';
    require_once 'config/data.php';

    /* SITE CONFIGS */

    /* SITE OPTIONS */
    options()->setDefaultLanguage('fr');

    /* LANGUAGES */
    // $fileTranslations = dirname(__FILE__) . DS . 'config/translations.php';
    // if (File::exists($fileTranslations)) {
    //     require_once $fileTranslations;
    // }

    // $tree = new Tree('config');
    // $tree->node('db')
    // ->children()
    //     ->setTest("test")
    //     ->getSelf()
    //     ->node('dkkd')
    //         ->children()
    //             ->setTest(15)
    //             ->getFather()
    //         ->children()
    //             ->setTest2(45);
    // $tree->node('db2')
    // ->children()
    //     ->setTest("testsqsq");

    // dieDump($tree->getNode('db2')->getTree()->getTest());
    // dieDump($tree->getNode('db')->getNode('dkkd')->getTree()->getTest());

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
