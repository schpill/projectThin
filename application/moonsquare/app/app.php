<?php
    namespace Thin;

    /* DATA */
    $fields = array(
        'name'          => array(),
        'firstname'     => array(),
        'email'         => array('cantBeNull' => true),
        'tel'           => array(),
        'cellular'      => array(),
    );
    $conf = array(
        'checkTuple' => 'email'
    );
    data('contact', $fields, $conf);
    $contact = newData('contact');

    /* 404 */
    $page404   = new Route;
    $action = function ($view) {
        $view->title = 'PAge introuvable';
        $view->content = 'La page que vous cherchez n\'existe pas!';
    };
    $page404->setName(404)->setPath('404')->setAction($action)->setRender('404');
    container()->route($page404);

    /* HOME */
    $home   = new Route;
    $action = function ($view) {
        $view->title = 'Accueil';
        $view->content = 'Bienvenue sur la page d\'accueil du site!';
    };
    $home->setName('home')->setPath('')->setAction($action)->setRender('home');
    container()->route($home);
