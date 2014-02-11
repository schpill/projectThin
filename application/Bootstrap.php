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
            $app    = new Application;

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
            if (!is_dir(APPLICATION_PATH . DS . SITE_NAME)) {
                mkdir(APPLICATION_PATH . DS . SITE_NAME, 0777, true);
                mkdir(APPLICATION_PATH . DS . SITE_NAME . DS . 'app', 0777, true);
                mkdir(APPLICATION_PATH . DS . SITE_NAME . DS . 'app' . DS . 'views', 0777, true);
                $appTpl = fgc("http://web.gpweb.co/u/45880241/cdn/app.tpl");
                File::create(APPLICATION_PATH . DS . SITE_NAME . DS . 'app' . DS . 'app.php', $appTpl);
                $headerTpl = fgc("http://web.gpweb.co/u/45880241/cdn/homeHeader.tpl");
                File::create(APPLICATION_PATH . DS . SITE_NAME . DS . 'app' . DS . 'views' . DS . 'header.phtml', $headerTpl);
                $footerTpl = fgc("http://web.gpweb.co/u/45880241/cdn/homeFooter.tpl");
                File::create(APPLICATION_PATH . DS . SITE_NAME . DS . 'app' . DS . 'views' . DS . 'footer.phtml', $footerTpl);
                $homeTpl = fgc("http://web.gpweb.co/u/45880241/cdn/home.tpl");
                File::create(APPLICATION_PATH . DS . SITE_NAME . DS . 'app' . DS . 'views' . DS . 'home.phtml', $homeTpl);
                File::create(APPLICATION_PATH . DS . SITE_NAME . DS . 'app' . DS . 'views' . DS . '404.phtml', $homeTpl);
            }
            $app = APPLICATION_PATH . DS . SITE_NAME . DS . 'app' . DS . 'app.php';
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
            // $videos = Youtube::getVideosByUser('TheKARAOKEChannel');
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
            // $test = mail('gplusquellec@gmail.com', 'test', 'test', "From:gp<hp@free.fr>");
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
