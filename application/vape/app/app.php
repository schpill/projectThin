<?php
    namespace Thin;
    use Swift_SmtpTransport as Transport;
    use Swift_Mailer as Mailer;
    use Swift_Message as Message;

    ini_set("memory_limit", '2000M');

    /* CONFIG FILES */
    require_once 'config/ini.php';
    require_once 'config/activeRecord.php';
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
    // $redis = redis();
    // $d = new \Datetime;
    // $redis->set('test', time());
    // dieDump($d->setTimestamp($redis->get("test")));
    // kv('test', time());
    // dieDump(kv('test'));
    // $redis = new Redis('127.0.0.1');
    // dieDump($redis->set(array('cool', time())));

    // $rand = function ($min, $max) {
    //     return rand($min, $max);
    // };

    // container()->event('rand', $rand);
    // dieDump(container()->rand(1000, 2000));

    // $db = new Litedb('option');
    // $all = $db->fetchAll()->groupBy('value')->fetch();
    // $db->newRow()->setName('rv')->setValue(50)->save();
    // $db->newRow()->setName('truc')->setValue(25)->save();
    // $db->newRow()->setName('machin')->setValue(200)->save();
    // $maj = $db->find(2)->setValue('fdfd')->save();
    // $maj = $db->find(1)->delete();
    // $db->find(1)->setName('parari')->save();
    // $db->find(1)->delete();
    // $all = $db->find(1)->test();
    // dieDump($all);
    // $new = $db->newRow()->setName('truc')->setValue(30);
    // dieDump($new->save());

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
    // $a = new Attributes('contact');
    // $contact = $a->record()->setName('Michel')->setEmail('Michel@gmail.com')->setPhone('5817776779');
    // $contact = $a->make($contact)->store();
    // $contact = $a->save($a->make($contact));
    // $res = $a->findOneByName('Gerald');
    // $res = $a->order('date_create', 'DESC')->first();
    // $res->trash();
    // $a->delete($res);
    // var_dump($res->display('name'));
    // var_dump($res->getName());
    // die(urlcencode('http://home.gpweb.co/browser.php?u=http://www.albumblog.com');
    // dieDump($res->assoc());

    // $ar = ar('ajf', 'user');
    // $o = $ar->find(1);
    // ->where('partner_id > :partner_id', array('partner_id' => 0))
    // ->where('partner_id < :partner_id', array('partner_id' => 1000))
    // ->fetch();
    // $o->setSkype('gerald_paris');
    // foreach ($o->getPartner()->getUsers() as $user) {
    //     dieDump($user->getPartner()->getUsers());
    // }
    // $db = new Sql('option', 'ajf');
    // $n = $db->make()->setName('test_' . time())->setValue('OK')->store();

    // $n = $db->make()->setName('test4')->setValue('OK')->store();
    // $res = $db->selectAll()->order('name')->fetch();
    // $res = $db->selectAll()->groupBy('value')->fetch();
    // $first = true;
    // foreach ($res as $row) {
    //     var_dump($row->display("name"));
    //     $row->setName(time())->store();
    //     // if($first) $row->trash();
    //     $first = false;
    // }
    // $sum = $db->selectAll()->order(array('name'), array('DESC'))->sum('date_create');
    // $avg = $db->selectAll()->order(array('name'), array('DESC'))->avg('date_create');
    // $min = $db->selectAll()->order(array('name'), array('DESC'))->min('date_create');
    // $max = $db->selectAll()->order(array('name'), array('DESC'))->max('date_create');
    // $limit = $db->selectAll()->order(array('name'), array('DESC'))->limit(10)->fetch();
    // var_dump($sum);
    // var_dump($avg);
    // var_dump($min);
    // var_dump($max);
    // print_r($limit);
    // exit;

    // $rand = function($u, $d) {
    //     return rand($u, $d);
    // };

    // $test = function() {
    //     return 'OK';
    // };

    // event('rand', $rand);
    // event('test', $test);
    // $t1 = fire('test');
    // $t = fire('rand', array(1000, 2000));
    // var_dump(container()->test());
    // dieDump(container()->rand(1000, 2000));

    // $u = Forever::instance('user');
    // $u->setLastVisit(time());
    // container()->setForeverUser($u);
    // dieDump($u);

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
