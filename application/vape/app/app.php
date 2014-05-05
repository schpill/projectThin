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

    event(
        'dump',
        function ($what) {
            echo '<pre>';
            print_r($what);
            echo '</pre>';
        }
    );

    event('entity', function() {
        static $i;
        if (null === $i) {
            $i = new Kvdb();
        }
        return $i;
    });

    event('kvs', function() {
        static $i;
        if (null === $i) {
            $i = new Kvdb();
        }
        return $i;
    });

    event('redis', function() {
        static $i;
        if (null === $i) {
            if (!extension_loaded('redis')) {
                $i = new \Predis\Client;
            } else {
                $i = new \Redis();
                $i->connect('localhost', 6379);
            }
        }
        return $i;
    });

    event('log', function($str) {
        error_log($str);
    });

    event('db', function($name) {
        static $i = array();
        $db = isAke($i, $name);
        if (empty($db)) {
            $i[$name] = $db = new Memorydb($name);
            // $i[$name] = $db = new Entitydb($name);
        }
        return $db;
    });

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


    function beforeTests()
    {
        $containerConfig    = null === container()->getConfig() ? new myConf : container()->getConfig();
        $conf               = array();

        $dbConf = new database();
        $dbConf->setUsername('root')
        ->setPassword('root')
        ->setAdapter('mysql')
        ->setDatabase("immosol")
        ->setHost("localhost");
        $conf['db'] = $dbConf;
        $containerConfig->setDb($conf);

        /* MODELS */
        container()->setConfig($containerConfig);

        // $db = container()->redis();
        // $db->set('db_test::1', json_encode('papa'));
        // $db->set('db_test::2', json_encode('maman'));
        // $rows = $db->keys('db_test::*');
        // foreach ($rows as $k => $row) {
        //     $tab = json_decode($db->get($row), true);
        //     var_dump($tab);
        // }
        // exit;

        // $db = new Dbeav('mytruck');
        // Dbeav::configs('mytruck', 'cache', 'redis');
        // Jsoneav::configs('truck', 'cache', 'redis');

        $functions = array();
        $functions['user'] = function() {
            $db = $this->db('user');
            return $db->find($this->getUser());
        };
        container()->db('product')->config('functions', $functions);
        // container()->db('product')->requires(array('stock'));
        container()->db('product')->defaults(array('stock' => rand(125, 151)));
        // container()->db('product')->uniques(array('stock'));
        // container()->db('product')->controls(
        //     array(
        //         'token' => function ($val) {
        //             var_dump($val);
        //             return strrev($val);
        //         },
        //     )
        // );

        $functions = array();
        $functions['products'] = function($object = false) {
            $db = $this->db('product');
            return true === $object ? $db->findObjectsByUser($this->getId()) : $db->findByUser($this->getId());
        };
        container()->db('user')->config('functions', $functions);


        $dbUser = container()->db('user');
        $dbUser->setCache(true);
        $dbProduct = container()->db('product');

        $dbProduct->setCache(true);
        $u = $dbUser
        ->create()
        ->setName('Plusquellec')
        ->setFirstname('Gérald')
        ->setEmail('gplusquellec@free.fr')
        ->save();
        // dieDump($u);
        // $u->export();
        var_dump($dbUser->countAll());
        $max = 0;
        for ($i = 0 ; $i < $max ; $i++) {
            $p = $dbProduct->create()
            ->setUser($u->getId())
            ->setToken(Utils::token())
            ->setStock()
            ->setPrice(rand(15000, 25000))
            ->save();
        }
        // dieDump($p);
        $res = $dbProduct->where('price > 2000')->order('price', 'desc')->first(true);
        dieDump($res->user()->products());
        // var_dump($dbBook->count());
        // $db->setCache(true);
        // set_time_limit(0);
        // $i = 0;
        // $max = 1000;
        // $max = 1;
        // while ($i < $max) {
        //     $i++;
        //     $car = array(
        //         'brand' => 'Fiat',
        //         'color' => $i . 'blue',
        //         'year'  => rand(1965, 2014),
        //         'price' => rand(12000, 25000),
        //         'stock' => rand(10, 200)
        //     );
        //     $r = $db->save($car);
        // }
        // die('coc');
        // dieDump($db->all(true));
        // $c = $db->find(2);
        // $c->setPrice(rand(12000, 25000))->setYear(rand(1965, 2014))->record();
        // $c = $db->find(2);
        // dieDump($r);
        // $r = rand(42000, 55000);
        // var_dump($db->find(4)->getPrice());
        // $v = $db->find(4)->setPrice($r)->setColor('white')->save();
        // var_dump($r, $db->find(4)->getPrice());
        // dieDump($db->find(58));
        // $cars = $db->where('price > 10')->order('price', 'DESC')->export();
        // dieDump(count($cars));
        // var_dump(count($cars));
        // dieDump(count($cars));
        // $r = rand(50000, 75000);
        // var_dump($r);
        // var_dump(count($cars));
        // foreach ($cars as $car) {
        //     var_dump($car);
        //     var_dump($db->toObject($car)->getId());
        //     var_dump($db->toObject($car)->getPrice());
        //     $db->toObject($car)->setPrice($r)->save();
        //     exit;
        // }
        // exit;
    }

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
    $controllers = glob(realpath(dirname(__file__) . DS . 'controllers') . DS . '*.php');
    if (count($controllers)) {
        foreach ($controllers as $controller) {
            include $controller;
        }
    }

    // beforeTests();
