<?php
    namespace Thin;
    use Swift_SmtpTransport as Transport;
    use Swift_Mailer as Mailer;
    use Swift_Message as Message;

    ini_set("memory_limit", '512M');

    /* CONFIG FILES */
    require_once 'config/ini.php';
    require_once 'config/db.php';
    require_once 'config/data.php';

    /* SITE CONFIGS */

    $db = function ($table, $db = 'project') {
        $table = Inflector::uncamelize(lcfirst($table));
        $table = Inflector::lower($table);
        return em($db, $table);
    };
    container()->setTable($db);

    $rs = function($table, $field, $relation, $db = 'project') {
        $containerConfig = container()->getConfig();
        $models = $containerConfig->getModels();
        $models[$db]['tables'][$table] = array();
        $models[$db]['tables'][$table]['relationship'] = array();
        $models[$db]['tables'][$table]['relationship'][$field] = $relation;
        $containerConfig->setModels($models);
        return container()->setConfig($containerConfig)->table($table);
    };
    container()->setRelationship($rs);

    $conf = function($key, $default = null) {
        $conf = container()->getAppConfig();
        if (!Arrays::is($conf)) {
            return value($default);
        }
        return arrayGet($conf, $key, $default);
    };
    container()->setConf($conf);

    $addConf = function($key, $value) {
        $conf = container()->getAppConfig();
        $conf = null === $conf ? array() : $conf;
        return container()->setAppConfig(arraySet($conf, $key, $value));
    };
    container()->setAddConf($addConf);

    $configs = array();
    $files = glob(dirname(__FILE__) . DS . 'ini' . DS . '*.php');
    if (count($files)) {
        foreach ($files as $file) {
            $exp        = explode(DS, $file);
            $segment    = Inflector::lower(repl('.php', '', Arrays::last($exp)));
            if (!Arrays::exists($segment, $configs)) {
                $configs[$segment] = array();
            }
            $tab = include($file);
            foreach ($tab as $key => $value) {
                $configs[$segment][$key] = $value;
            }
        }
    }
    container()->setAppConfig($configs);

    /* SITE OPTIONS */
    options()->setDefaultLanguage('fr');

    // dieDump(\Flo\Services\Data::getTest());
    // $config = array(
    //     'host' => 'smtp.mandrillapp.com',
    //     'login' => 'clementdharcourt@albumblog.com',
    //     'password' => 'BT99CIkPBCsoWX5otYpo9g',
    //     'port' => 587,
    //     'secure' => null,
    //     'auth' => true,
    //     'debug' => false
    // );
    // $html = true;
    // $mail = new Smtp($config);
    // $mail->to('gplusquellec@gmail.com')->from('gplusquellec@gmail.com', 'GG')->subject('test')->attach("http://laravel.com/assets/img/logo-head.png");
    // if (true === $html) {
    //     $result = $mail->body('<div style="color: red; font-weight: bold;">test</div>')->send();
    // } else {
    //     $result = $mail->text($body)->sendText();
    // }
    // dieDump($result);

    /* CONTROLLERS */

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
