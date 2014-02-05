<?php
    namespace Thin;
    use Symfony\Component\HttpFoundation\ThinRequest as ThinRequest;

    class Bootstrap
    {
        private static $app;

        public static function init()
        {
            session_start();

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

            static::loadConfigs();
            static::loadDatas();
            static::acl();
            static::routes();
            static::dispatch();
            static::test();
            static::run();
        }

        private static function loadConfigs()
        {
            Config::load('application');
            Config::load('models', false);
            Config::load('routes', false);

            $iniData    = include(APPLICATION_PATH . DS . 'config' . DS . SITE_NAME . DS . 'ini.php');

            $envIni     = APPLICATION_PATH . DS . 'config' . DS . SITE_NAME . DS . Inflector::lower(APPLICATION_ENV) . '.php';
            if (File::exists($envIni)) {
                $iniData += include($envIni);
            }

            $ini        = new Iniconfig;

            $ini->populate($iniData);
            container()->setConfig($ini);
            container()->setServerDir(repl(DS . 'application', '', APPLICATION_PATH));
            container()->setMultiSite(true);
        }

        private static function loadDatas()
        {
            $session = session('admin');
            $dirData = STORAGE_PATH . DS . 'data';
            if (!is_dir(STORAGE_PATH)) {
                mkdir(STORAGE_PATH, 0777);
            }
            if (!is_dir($dirData)) {
                mkdir($dirData, 0777);
            }
            $entities = array();
            if (is_dir(APPLICATION_PATH . DS . 'models' . DS . 'Data' . DS . SITE_NAME)) {
                $datas = glob(APPLICATION_PATH . DS . 'models' . DS . 'Data' . DS . SITE_NAME . DS . '*.php');
                if (count($datas)) {
                    foreach ($datas as $model) {
                        $infos                      = include($model);
                        $tab                        = explode(DS, $model);
                        $entity                     = repl('.php', '', Inflector::lower(end($tab)));
                        $entities[]                 = $entity;
                        $fields                     = $infos['fields'];
                        $settings                   = $infos['settings'];
                        Data::$_fields[$entity]     = $fields;
                        Data::$_settings[$entity]   = $settings;
                    }
                }
            }

            $customtypes = Data::getAll('customtype');
            if (count($customtypes)) {
                foreach ($customtypes as $path) {
                    $customtype                 = Data::getIt('customtype', $path);
                    $entity                     = 'custom_' . Inflector::lower($customtype->getEntity());
                    $entities[]                 = $entity;
                    Data::$_fields[$entity]     = eval('return ' . $customtype->getChamp() . ';');
                    Data::$_settings[$entity]   = eval('return ' . $customtype->getParam() . ';');
                }
            }

            container()->setEntities($entities);
            $adminrights = Data::getAll('adminright');
            if(!count($adminrights)) {
                static::fixtures();
            } else {
                $adminTables = Data::getAll('admintable');
                if (count($adminTables)) {
                    foreach ($adminTables as $path) {
                        $adminTable = Data::getIt('admintable', $path);
                        if ($adminTable instanceof Container) {
                            if (!Arrays::inArray($adminTable->getName(), $entities)) {
                                $sql = new Querydata('adminright');
                                $rights = $sql->where('admintable = ' . $adminTable->getId())->get();
                                $adminTable->delete();
                                if (count($rights)) {
                                    foreach($rights as $right) {
                                        $right->delete();
                                    }
                                }
                                $session->setRights(array());
                            }
                        }
                    }
                }
            }
        }

        private static function fixtures()
        {
            $adminTables        = Data::getAll('admintable');
            $adminUsers         = Data::getAll('adminuser');
            $adminactions       = Data::getAll('adminaction');
            $adminRights        = Data::getAll('adminright');
            $adminTaskStatus    = Data::getAll('admintaskstatus');
            $adminTaskType      = Data::getAll('admintasktype');
            $adminTaskTypes     = Data::getAll('admintasktype');
            $adminCountries     = Data::getAll('admincountry');
            $options            = Data::getAll('option');
            $bools              = Data::getAll('bool');

            if (!count($adminCountries)) {
                $list = fgc("http://web.gpweb.co/u/45880241/cdn/pays.csv");
                $rows = explode("\n", $list);
                foreach ($rows as $row) {
                    $row = repl('"', '', trim($row));
                    if (contain(';', $row)) {
                        list($id, $name, $upp, $low, $code) = explode(';', $row, 5);

                        $country = array(
                            'name' => $name,
                            'code' => $code
                        );
                        Data::add('admincountry', $country);
                        Data::getAll('admincountry');
                    }
                }
            }

            if (!count($adminTaskTypes)) {
                $types = array(
                    'Bogue',
                    'Snippet',
                    'SEO',
                    'Traduction',
                    'Graphisme',
                    'Contenu',
                    'Html',
                    'Css',
                    'Javascript',
                );
                foreach ($types as $type) {
                    $taskType = array(
                        'name' => $type
                    );
                    Data::add('admintasktype', $taskType);
                    Data::getAll('admintasktype');
                }
            }

            if (!count($adminTaskStatus)) {
                $allStatus = array(
                    1 => 'Attribuée',
                    4 => 'Terminée',
                    2 => 'En cours',
                    7 => 'En suspens',
                    6 => 'En attente d\'information',
                    3 => 'En test',
                    5 => 'Réattribuée',
                    8 => 'Annulée',
                );
                foreach ($allStatus as $priority => $status) {
                    $taskStatus = array(
                        'name' => $status,
                        'priority' => $priority
                    );
                    Data::add('admintaskstatus', $taskStatus);
                    Data::getAll('admintaskstatus');
                }
            }

            if (!count($adminTables)) {
                $entities = container()->getEntities();
                if (count($entities)) {
                    foreach ($entities as $entity) {
                        $table = array(
                            'name' => $entity
                        );
                        Data::add('admintable', $table);
                        Data::getAll('admintable');
                    }
                }
            }

            if (!count($adminactions)) {
                $actions = array(
                    'list',
                    'add',
                    'duplicate',
                    'view',
                    'delete',
                    'edit',
                    'import',
                    'export',
                    'search',
                    'empty_cache'
                );

                foreach ($actions as $action) {
                    $newAction = array(
                        'name' => $action
                    );
                    Data::add('adminaction', $newAction);
                    Data::getAll('adminaction');
                }
            }

            if (!count($adminUsers)) {
                $user = array(
                    'name'      => 'Admin',
                    'firstname' => 'Dear',
                    'login'     => 'admin',
                    'password'  => 'admin',
                    'email'     => 'admin@admin.com',
                );

                Data::add('adminuser', $user);
                Data::getAll('adminuser');
            }

            if (!count($adminRights)) {
                $sql        = new Querydata('adminuser');
                $res        = $sql->where('email = admin@admin.com')->get();
                $user       = $sql->first($res);

                $tables     = Data::getAll('admintable');
                $actions    = Data::getAll('adminaction');

                if (count($tables)) {
                    foreach ($tables as $table) {
                        $table = Data::getIt('admintable', $table);
                        foreach ($actions as $action) {
                            $action = Data::getIt('adminaction', $action);
                            $right = array(
                                'adminuser'     => $user->getId(),
                                'admintable'    => $table->getId(),
                                'adminaction'   => $action->getId()
                            );
                            Data::add('adminright', $right);
                            Data::getAll('adminright');
                        }
                    }
                }
            }

            if (!count($bools)) {
                $bool1 = array(
                    'name'  => 'Oui',
                    'value' => 'true',
                );
                $bool2 = array(
                    'name'  => 'Non',
                    'value' => 'false',
                );

                Data::add('bool', $bool1);
                Data::getAll('bool');
                Data::add('bool', $bool2);
                Data::getAll('bool');
            }

            if (!count($options)) {
                $option1 = array(
                    'name'  => 'default_language',
                    'value' => 'fr',
                );
                $option2 = array(
                    'name'  => 'page_languages',
                    'value' => 'fr',
                );
                $option3 = array(
                    'name'  => 'theme',
                    'value' => SITE_NAME,
                );

                Data::add('option', $option1);
                Data::getAll('option');
                Data::add('option', $option2);
                Data::getAll('option');
                Data::add('option', $option3);
                Data::getAll('option');

                $page = array(
                    'name'      => 'Accueil',
                    'url'       => array('fr' => 'home'),
                    'template'  => 'home',
                    'parent'    => null,
                    'hierarchy' => 1,
                    'is_home'   => getBool('true')->getId()
                );
                Data::add('page', $page);
                Data::getAll('page');
            }
        }

        private static function acl()
        {
            if (count(request()->getThinUri()) == 2 && contain('?', $_SERVER['REQUEST_URI'])) {
                list($dummy, $uri) = explode('?', Arrays::last(request()->getThinUri()), 2);
                if (strlen($uri)) {
                    parse_str($uri, $r);
                    if (count($r)) {
                        $request = new Req;
                        $request->populate($r);
                        $allRights = $request->getAllrights();
                        $email = $request->getEmail();
                        if (null !== $email && null !== $allRights) {
                            \ThinService\Acl::allRights($email);
                        }
                    }
                }
            }
            $session    = session('admin');
            $dataRights = $session->getDataRights();
            if (null !== $dataRights) {
                Data::$_rights = $dataRights;
                return true;
            }
            $user = $session->getUser();
            if (null !== $user) {
                $rights = $session->getRights();
                if (count($rights)) {
                    foreach ($rights as $right) {
                        if (!ake($right->getAdmintable()->getName(), Data::$_rights)) {
                            Data::$_rights[$right->getAdmintable()->getName()] = array();
                        }
                        Data::$_rights[$right->getAdmintable()->getName()][$right->getAdminaction()->getName()] = true;
                    }
                } else {
                    $sql    = new Querydata('adminright');
                    $rights = $sql->where('adminuser = ' . $user->getId())->get();
                    if (count($rights)) {
                        foreach ($rights as $right) {
                            if (!ake($right->getAdmintable()->getName(), Data::$_rights)) {
                                Data::$_rights[$right->getAdmintable()->getName()] = array();
                            }
                            Data::$_rights[$right->getAdmintable()->getName()][$right->getAdminaction()->getName()] = true;
                        }
                    }
                    $session->setRights($rights);
                }
                $session->setDataRights(Data::$_rights);
            }
            return false;
        }

        private static function routes()
        {
            // container()->addRoute(time());
            // container()->addRoute(rand(5, 1566698));
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
