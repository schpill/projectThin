<?php
    namespace Thin;
    use Symfony\Component\HttpFoundation\ThinRequest as ThinRequest;

    class Bootstrap
    {
        private static $app;

        public static function init()
        {
            session_start();

            if (contain('show_menu=false', $_SERVER['REQUEST_URI'])) {
                container()->setNoMenu(true);
                $_SERVER['REQUEST_URI'] = repl('?show_menu=false', '', $_SERVER['REQUEST_URI']);
            }

            Request::$foundation = ThinRequest::createFromGlobals();

            define('NL', "\n");
            define('ISAJAX', Inflector::lower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest');

            Utils::cleanCache();
            $logger = new Log();
            $app    = container();

            $app->setLogger($logger);
            Utils::set('isTranslate', false);

            Utils::set('app', $app);

            static::$app = $app;

            static::app();
            static::loadConfigs();
            Cms::loadDatas();
            Cms::acl();
            static::dispatch();
            static::test();
            static::run();
        }

        private static function app()
        {
            $appDir = APPLICATION_PATH . DS . SITE_NAME . DS . 'app';
            if (!is_dir(APPLICATION_PATH . DS . SITE_NAME)) {
                mkdir(APPLICATION_PATH . DS . SITE_NAME, 0777, true);
                mkdir($appDir, 0777, true);
                mkdir($appDir . DS . 'views', 0777, true);
                mkdir($appDir . DS . 'config', 0777, true);

                $appTpl = fgc("http://web.gpweb.co/u/45880241/cdn/app.tpl");
                File::create($appDir . DS . 'app.php', $appTpl);

                $dbTpl = fgc("http://web.gpweb.co/u/45880241/cdn/db.tpl");
                File::create($appDir . DS . 'config' . DS . 'db.php', $dbTpl);

                $iniTpl = fgc("http://web.gpweb.co/u/45880241/cdn/ini.tpl");
                File::create($appDir . DS . 'config' . DS . 'ini.php', $iniTpl);

                $dataTpl = fgc("http://web.gpweb.co/u/45880241/cdn/data.tpl");
                File::create($appDir . DS . 'config' . DS . 'data.php', $dataTpl);

                $headerTpl = fgc("http://web.gpweb.co/u/45880241/cdn/homeHeader.tpl");
                File::create($appDir . DS . 'views' . DS . 'header.phtml', $headerTpl);

                $footerTpl = fgc("http://web.gpweb.co/u/45880241/cdn/homeFooter.tpl");
                File::create($appDir . DS . 'views' . DS . 'footer.phtml', $footerTpl);

                $homeTpl = fgc("http://web.gpweb.co/u/45880241/cdn/home.tpl");
                File::create($appDir . DS . 'views' . DS . 'home.phtml', $homeTpl);
                File::create($appDir . DS . 'views' . DS . '404.phtml', $homeTpl);
            }
            $app = $appDir . DS . 'app.php';
            require_once($app);
        }

        private static function loadConfigs()
        {
            $configContainer = container()->getAppConfig();
            $iniData = empty($configContainer) ? array() : $configContainer;

            if (File::exists(APPLICATION_PATH . DS . 'config' . DS . SITE_NAME . DS . 'ini.php')) {
                $iniData += include(APPLICATION_PATH . DS . 'config' . DS . SITE_NAME . DS . 'ini.php');
            }

            $envIni = APPLICATION_PATH . DS . 'config' . DS . SITE_NAME . DS . Inflector::lower(APPLICATION_ENV) . '.php';
            if (File::exists($envIni)) {
                $iniData += include($envIni);
            }

            $ini = new Iniconfig;

            $ini->populate($iniData);
            container()->setConfig($ini);
            container()->setServerDir(repl(DS . 'application', '', APPLICATION_PATH));
            container()->setMultiSite(true);
        }

        private static function dispatch()
        {
            Router::dispatch();
            Router::language();
        }

        private static function run()
        {
            Router::run();
        }

        private static function test()
        {
            // $d = new Duproprio;
            // $q = "SELECT * FROM proprietes WHERE LENGTH(city) > 0 ORDER BY price DESC";
            // $res = $d->getDb()->query($q);
            // while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            //     $obj = Data::row('propriete', $row);
            //     $s = $obj->save();
            //     print_r($s);
            //     exit;
            // }
            // exit;
            // $d->getAds();dieDump($d);
            // set_time_limit(0);
            // $db = dm("propriete");
            // $all = $db->all()->setCache(true)->get();
            // foreach ($all as $obj) {
            //     $d->addDb($obj);
            // }
            // exit;
            // $evers = array();
            // $deleted = array();
            // foreach ($all as $property) {
            //     if ($property instanceof Container) {
            //         $partnerId = $property->getPartnerId();
            //         if (Arrays::in($partnerId, $evers)) {
            //             array_push($deleted, $property->id);
            //             $property->delete();
            //         } else {
            //             array_push($evers, $partnerId);
            //         }
            //     }
            // }
            // dieDump($db->first($all)->_fields);
            // dieDump($all);
            // $d = new Duproprio;
            // $p = $d->extract(6880);
            // dieDump($p);
            // $c = new Centris;
            // echo time();
            // $db = dm('adminright');
            // $res = $db->join('admintable', 'name = admintable')->order('adminaction')->get();
            // foreach ($res as $row) {
            //     var_dump($row->getAdminaction()->getName());
            // }echo time();exit;
            // $db = dm('adminaction');
            // dieDump($db->all()->order(array('name', 'id'))->get());
            // // $kv = new Keyvalue();
            // $db = new Querydata;
            // // $tables = $db->getTables();
            // $fields = array(
            //     'name'  => array('cantBeNull' => true),
            //     'value' => array('cantBeNull' => true)
            // );
            // $settings = array(
            //     'checkTuple' => 'name'
            // );
            // $t = $db->table('truc', $fields, $settings);
            // $db = new Querydata('trucc');
            // dieDump($db->insert(array(array('papa' => 'fdfd', 'value' => 'hghg'))));
            // $db = dm('adminright');
            // $res = $db->join('admintable', 'name = admintable')->order('adminaction')->get();
            // foreach ($res as $row) {
            //     var_dump($row->getAdminaction()->getName());
            // }exit;
            // $db = dm('adminaction');
            // $res = $db->where('name = list')->get();
            // $action = $db->first($res);
            // dieDump($action->getAdminrights());
//             @font-face {
//             font-family: "proxima_nova";
//             src: url("https://www.dropbox.com/static/fonts/proximanova/prox=
// ima-nova-regular.otf") format("opentype");
//             font-weight: normal;
//          }
            // $item = array(
            //     'currency'           => 'CAD',
            //     'quantity'           => 1,
            //     'price'              => 100,
            //     'name'               => 'Objet test',
            //     'id'                 => '123456',
            // );
            // $items = array($item);

            // $config = array(
            //     'environment'        => 'development',
            //     'returnUrl'          => 'http://www.gpweb.co/success',
            //     'cancelUrl'          => 'http://www.gpweb.co/cancel',
            //     'currency'           => 'CAD',
            //     'total'              => 135,
            //     'discount_amount'    => 10,
            //     'subtotal'           => 100,
            //     'tax'                => 20,
            //     'shipping'           => 15,
            //     'description'        => 'Liste de vos achats',
            //     'items'              => $items,
            //     'clientId'           => 'AR1gYxBYuhVXGHInUsHgSXTZ_OBWj9AsGNPg--92OPZqLsD089GsFfeb8CHB',
            //     'clientSecret'       => 'EDh0XRCYD34dDH-n3ad6n-AzYOm3Ko_6AlcwUhMGrJG_5r9lMoKXqBR5hl-7'
            // );
            // $urls = Paypal::getUrlPaypalPayment($config);
            // token=EC-2EL34077U2935391T&PayerID=GKA3B3WH7ASZ6
            // https://api.sandbox.paypal.com/v1/payments/payment/PAY-2HA413672C0466420KMIPWWA/execute
            // dieDump($urls);
            // dieDump(Paypal::execPayment(array(
            //     'clientId'           => 'AR1gYxBYuhVXGHInUsHgSXTZ_OBWj9AsGNPg--92OPZqLsD089GsFfeb8CHB',
            //     'clientSecret'       => 'EDh0XRCYD34dDH-n3ad6n-AzYOm3Ko_6AlcwUhMGrJG_5r9lMoKXqBR5hl-7',
            //     'environment'        => 'development',
            //     'PayerID' => 'GKA3B3WH7ASZ6',
            //     'execute' => 'https://api.sandbox.paypal.com/v1/payments/payment/PAY-7FW43718AD309424BKMIP5JI/execute',
            // )));
            // $db = new Querydata('page');
            // $res = $db->getAll()->groupBy('name')->get();
            // dieDump($res);
            // $etat = Data::last('etat');
            // $produit = Data::first('produit');
            // $produit->setEtat($etat);
            // dieDump($produit->getEtat() == $etat);
            // $cool = function($a, $b) {
            //     return rand($a, $b);
            // };
            // container()->closure('cool', $cool);

            // $t =  container()->cool(20, 400);
            // dieDump($t);
            // $query  = new Querydata('youtube');
            // $query2 = new Querydata('youtube');
            // $res    = $query->where("title LIKE '%p%'")
            // ->whereAnd("title LIKE 'zzy'")
            // ->whereOr(
            //     $query2->where("title LIKE '%wwz%'")
            //     ->sub()
            // )
            // ->order('title')
            // ->get();
            // dieDump($res);
            // $test = Data::newApikey(array('key' => 'cool', 'resource' => 'OK'));
            // $test->save();
            // dieDump($test);
            // $videos = Youtube::getVideosByUser('TheKARAOKEChannel');dieDump($videos);
            // foreach ($videos as $video) {
            //     Data::add('youtube', $video, 'youtube_id');
            // }
            // dieDump($video);
            // $res = Data::query('youtube', '', 0, 0, 'title');
            // foreach ($res as $row) {
            //     echo '<a href="http://www.youtube.com/watch?v=' . $row->getYoutubeId() . '" target="_ytk">' . $row->getTitle() . '</a><hr />';
            // }
            // exit;
            // $mail = email()->setTo('gplusquellec@gmail.com')->setSubject('test')->setBody('test')->setHeaders("From: gg<gplusquellec@free.fr>");
            // dieDump($mail->send());
            // $smtp = container()->getIni();
            // dieDump($smtp->getSmtp());
            // $i = Allocine::save(10141);
            // dieDump($i);
            // $c = Data::getAll('film');
            // $obj = Data::getObject(current($c));
            // dieDump($obj->genre);
            // $test = Utils::mail('gplusquellec@gmail.com', 'test', 'test', "From:gp<hp@free.fr>");
            // $truc = new Truc;
            // $truc->app = 15;
            // $truc->boot = function () use ($truc) {
            //     $val = rand(1, 9999);
            //     // $truc->rand = $val;
            //     $truc['rand'] = $val;
            //     return $truc;
            // };
            // var_dump($test);exit;
            // info(static::$app);
            // $tab = array(
            //     'title' => 'Star Wars',
            //     'year' => '1978',
            //     'country' => 'United States',
            // );
            // $url = 'http://cc/api/eav/b4e290a5f1c3ac61704133a57021881b/set/movie/' . base64_encode(serialize($tab));
            // die($url);
            // $row = Data::add('apikey', array('resource' => 'eav', 'key' => 'b4e290a5f1c3ac61704133a57021881c'));
            // $cart = new Cart('Pilouf');
            // $cart->add('ok', 'tv', 1, 589);
            // $cart->add('456', 'pc', 29, 899);
            // $cart->remove('c1a4cde0b13dff4deb02f6a18c15b58c');m);
            // $session = Sessionbis::instance('test');
            // $session->setParam(time());
            // dieDump($row);
        }
    }
