<?php
    namespace Thin;
    class staticController extends Controller
    {
        public function init()
        {
            $this->view->titleAdmin = "GP";
            $tab = explode('/', $_SERVER['REQUEST_URI']);
            $type = Arrays::last($tab);
            $action = container()->getAction();
            if (!empty($action)) {
                if (!Arrays::inArray($action, array('login', 'logout', 'dashboard', 'no-right'))) {
                    $session = $this->checkSession();
                    $this->view->user   = $session->getUser();
                    $acls               = $session->getUser()->getRights();
                    $types = array();
                    if (count($acls) && null !== $this->view->user) {
                        foreach ($acls as $type => $rights) {
                            Data::$_rights[$type] = $rights;
                            array_push($types, $type);
                        }
                    }
                    asort($types);
                    $this->view->types  = $types;
                }
            }

            $action = $tab[count($tab) - 3];

            if (Arrays::inArray($action, array('edit', 'duplicate', 'delete', 'view'))) {
                $type = $tab[count($tab) - 2];
            }
            $file = APPLICATION_PATH . DS . 'entities' . DS . 'admin' . DS . ucfirst(Inflector::lower($type)) . '.php';
            if (File::exists($file)) {
                $config = include($file);
                $this->view->config  = $config;
            }
            $export = request()->getCrudTypeExport();
            if (!empty($export)) {
                $this->noRender();
            } else {
                $this->view->request = request();
            }
            if (strlen($type)) {
                $this->view->_settings  = ake($type, Data::$_settings) ? Data::$_settings[$type] : array();
            }
        }

        public function preDispatch()
        {

        }

        public function logoutAction()
        {
            $_SESSION = array();
            $route = new Route;
            $route->setAction('login');
            $this->forward($route);
        }

        public function importAction()
        {
            $type = request()->getType();
            if (!empty($type)) {
                if (false === can($type, 'import')) {
                    $this->_noRight();
                }
                $this->view->action = (null === request()->getAction()) ? 1 : request()->getAction();
                $this->view->title  = 'Import';

                if (isset($_FILES['csv']) && is_uploaded_file($_FILES['csv']["tmp_name"]) && $_FILES['csv']["error"] == 0) {
                    $this->view->action = 2;
                    $ficTmp             = CACHE_PATH . DS . $_FILES['csv']["name"];
                    File::delete($ficTmp);
                    copy($_FILES['csv']["tmp_name"], $ficTmp);

                    $file                   = file($ficTmp);
                    $row                    = Arrays::first($file);
                    $this->view->file       = $ficTmp;
                    $this->view->row        = $row;
                    $this->view->separator  = request()->getSeparator();
                    $this->view->fields     = ake($type, Data::$_fields) ? Data::$_fields[$type] : array();
                }
                if (isset($_POST['file'])) {
                    $fields     = ake($type, Data::$_fields) ? Data::$_fields[$type] : array();
                    $file       = file($_POST['file']);
                    foreach ($file as $row) {
                        $row        = trim($row);
                        $tmpfields  = explode($_POST['separator'], $row);
                        $data       = array();
                        for ($i = 0 ; $i < count($tmpfields) ; $i++) {
                            $value          = trim($tmpfields[$i]);
                            $field          = $_POST[$i];
                            $data[$field]   = $value;
                        }
                        Data::add($type, $data);
                    }
                    File::delete($_POST['file']);
                    Router::redirect(URLSITE . 'backadmin/item/' . $type);
                }
            } else {
                $route = new Route;
                $route->setAction('dashboard');
                $this->forward($route);
            }
        }

        public function  noRightAction()
        {

        }

        public function loginAction()
        {
            $request = request();
            $username = $request->getUsername();
            $password = $request->getPassword();
            if (!empty($username) && !empty($password)) {
                $error = \ThinService\Acl::check($username, $password, 'admin');
                if (false === $error) {
                    $route = new Route;
                    $route->setAction('dashboard');
                    $this->forward($route);
                } else {
                    $this->_noRight();
                }
            }
            $this->view->title = 'Se connecter';
        }

        private function _noRight()
        {
            $route = new Route;
            $route->setAction('no-right');
            $this->forward($route);
        }

        public function dashboardAction()
        {
            $session            = $this->checkSession();
            $this->view->user   = $session->getUser();
            $acls               = $session->getUser()->getRights();
            $types = array();
            if (count($acls) && null !== $this->view->user) {
                foreach ($acls as $type => $rights) {
                    Data::$_rights[$type] = $rights;
                    array_push($types, $type);
                }
            }
            asort($types);
            $this->view->types  = $types;
            $this->view->title  = 'Tableau de bord';
            $this->view->remain = round(100 - ((31 - date('d')) * 2.06), 2);
        }

        public function itemAction()
        {
            $type = request()->getType();
            if (null === $type) {
                $tab = explode('/', $_SERVER['REQUEST_URI']);
                $type = Arrays::last($tab);
            }

            if (false === can($type, 'list')) {
                $this->_noRight();
            }

            if (File::exists(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . Inflector::lower($type) . '-list.phtml')) {
                $this->view->viewRenderer(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . Inflector::lower($type) . '-list.phtml');
            } else {
                $this->view->viewRenderer(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . 'default-list.phtml');
            }

            $settings       = ake($type, Data::$_settings) ? Data::$_settings[$type] : array();

            $page           = (null === request()->getPage())        ? 1     : request()->getPage();
            $where          = (null === request()->getWhere())       ? null  : request()->getWhere();
            $typeExport     = (null === request()->getTypeExport())  ? null  : request()->getTypeExport();
            $order          = (null === request()->getOrder())       ? (ake('orderList', $settings)) ? $settings['orderList'] : 'date_create' : request()->getOrder();
            $orderDirection = (null === request()->getOrderDirection()) ? (ake('orderListDirection', $settings)) ? $settings['orderListDirection'] : 'DESC' : request()->getOrderDirection();

            $whereData = '';
            if (!empty($where)) {
                $whereData = $this->_parseQuery($where);
            }

            $limit                  = (ake('itemsByPage', $settings)) ? $settings['itemsByPage'] : 25;

            $offset                 = ($page * $limit) - $limit;

            $this->view->title      = 'Liste';
            $this->view->type       = $type;
            $this->view->search     = \ThinHelper\Html::makeSearch($type);

            if (contain(' && ', $whereData)) {
                $tabConditions  = explode(' && ', $whereData);
                $init           = true;
                foreach ($tabConditions as $query) {
                    $db          = new Querydata($type);
                    $res         = $db->where($query)->sub();
                    if (true === $init) {
                        $init    = false;
                        $results = $res;
                    } else {
                        $results = array_intersect($results, $res);
                    }
                }
                $db         = new Querydata($type);
                $results    = $db->order($order, $orderDirection)->get($results);
            } else {
                $db         = new Querydata($type);
                $results    = $db->where($whereData)->order($order, $orderDirection)->get();
            }

            // $results2 = Data::query($type, $whereData, 0, 0, $order, $orderDirection);

            if (!empty($typeExport)) {
                $funcExport = 'export' . ucfirst(Inflector::lower($typeExport));
                \ThinService\Admin::$funcExport($results, $type);
                exit;
            }

            $this->view->total = $total = count($results);
            $this->view->first = $offset + 1;
            $this->view->last  = $offset + $limit;
            if ($total < $this->view->last) {
                $this->view->last = $total;
            }

            $last                   = ceil($total / $limit);
            $paginator              = new Paginator($results, $page, $total, $limit, $last);
            $this->view->data       = $paginator->getItemsByPage();
            $this->view->pagination = $paginator->links();
            $this->view->export     = array();
            if (!ake('notExportablePdf', $settings)) {
                $this->view->export[] = 'pdf';
            }
            if (!ake('notExportableExcel', $settings)) {
                $this->view->export[] = 'excel';
            }
            if (!ake('notExportableCsv', $settings)) {
                $this->view->export[] = 'csv';
            }
        }

        private function _parseQuery($queryJs)
        {
            $queryJs = substr($queryJs, 9, -2);

            $query = repl('##', ' && ', $queryJs);
            $query = repl('%%', ' ', $query);
            $query = repl('LIKESTART', 'LIKE', $query);
            $query = repl('LIKEEND', 'LIKE', $query);
            $query = repl("'", '', $query);
            return $query;
        }

        public function itemAddAction()
        {
            $tab = explode('/', $_SERVER['REQUEST_URI']);
            $type = Arrays::last($tab);
            if (false === can($type, 'add')) {
                $this->_noRight();
            }
            if (count($_POST)) {
                Data::add($type);
                Utils::go(URLSITE . 'backadmin/item/' . $type);
            }
            if (File::exists(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . Inflector::lower($type) . '-add.phtml')) {
                $this->view->viewRenderer(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . Inflector::lower($type) . '-add.phtml');
            } else {
                $this->view->viewRenderer(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . 'default-add.phtml');
            }
            $this->view->title = 'Ajouter';
            $this->view->type = $type;
            $this->view->model = Data::$_fields[$type];
        }

        public function itemViewAction()
        {
            $type   = request()->getType();
            $id     = request()->getId();
            $key    = request()->getKey();
            if (false === can($type, 'view')) {
                $this->_noRight();
            }
            $check  = \ThinHelper\Html::checkKey($id, $key);
            if (false === $check) {
                Utils::go(URLSITE . 'backadmin/item/' . $type);
            }
            $item   = Data::getById($type, $id);
            if (File::exists(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . Inflector::lower($type) . '-view.phtml')) {
                $this->view->viewRenderer(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . Inflector::lower($type) . '-view.phtml');
            } else {
                $this->view->viewRenderer(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . 'default-view.phtml');
            }
            $this->view->title = 'Afficher';
            $this->view->type = $type;
            $this->view->item = $item;
            $this->view->model = Data::getModel($type);
        }

        public function itemEditAction()
        {
            $type   = request()->getType();
            if (false === can($type, 'edit')) {
                $this->_noRight();
            }
            $id     = request()->getId();
            $key    = request()->getKey();
            $check  = \ThinHelper\Html::checkKey($id, $key);
            if (false === $check) {
                Router::redirect(URLSITE . 'backadmin/item/' . $type);
            }
            if (count($_POST)) {
                Data::edit($type, $id);
                Router::redirect(URLSITE . 'backadmin/item/' . $type);
            }
            $item   = Data::getById($type, $id);
            if (File::exists(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . Inflector::lower($type) . '-edit.phtml')) {
                $this->view->viewRenderer(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . Inflector::lower($type) . '-edit.phtml');
            } else {
                $this->view->viewRenderer(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . 'default-edit.phtml');
            }
            $this->view->title  = 'Mettre à jour';
            $this->view->type   = $type;
            $this->view->item   = $item;
            $this->view->key    = $key;
            $this->view->model = Data::getModel($type);
        }

        public function itemDuplicateAction()
        {
            $type   = request()->getType();
            if (false === can($type, 'duplicate')) {
                $this->_noRight();
            }
            $id     = request()->getId();
            $key    = request()->getKey();
            $check  = \ThinHelper\Html::checkKey($id, $key);
            if (false === $check) {
                Router::redirect(URLSITE . 'backadmin/item/' . $type);
            }
            if (count($_POST)) {
                Data::add($type);
                Router::redirect(URLSITE . 'backadmin/item/' . $type);
            }
            $item   = Data::getById($type, $id);
            if (File::exists(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . Inflector::lower($type) . '-duplicate.phtml')) {
                $this->view->viewRenderer(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . Inflector::lower($type) . '-duplicate.phtml');
            } else {
                $this->view->viewRenderer(APPLICATION_PATH . DS . 'modules' . DS . 'admin' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . 'default-duplicate.phtml');
            }
            $this->view->title  = 'Dupliquer';
            $this->view->type   = $type;
            $this->view->item   = $item;
            $this->view->key    = $key;
            $this->view->model = Data::getModel($type);
        }

        public function itemDeleteAction()
        {
            $type   = request()->getType();
            if (false === can($type, 'delete')) {
                $this->_noRight();
            }
            $id     = request()->getId();
            $key    = request()->getKey();
            $check  = \ThinHelper\Html::checkKey($id, $key);
            if (false === $check) {
                Utils::go(URLSITE . 'backadmin/item/' . $type);
            }
            Data::delete($type, $id);
            Utils::go(URLSITE . 'backadmin/item/' . $type);
            $this->view->model = Data::getModel($type);
        }

        private function checkSession()
        {
            $session = session('admin');
            if (null === $session->getUser()) {
                $route = new Route;
                $route->setAction('login');
                $this->forward($route);
            }
            return $session;
        }

        private function model($type)
        {
            $file = APPLICATION_PATH . DS . 'entities' . DS . 'admin' . DS . ucfirst(Inflector::lower($type)) . '.php';
            if (File::exists($file)) {
                $model = include($file);
                return $model;
            }
            return array('fields' => array());
        }

        private function addForm($type)
        {
            $model      = $this->model($type);
            $fields     = $model['fields'];
            $form       = array();
            foreach ($fields as $key => $fieldInfos) {
                $hidden = false;
                if (ake('hidden', $fieldInfos)) {
                    $hidden = $fieldInfos['hidden'];
                }
                if (ake('defaultValue', $fieldInfos)) {
                    $value = $fieldInfos['defaultValue'];
                }
                $continue = true;
                if (ake('onForm', $fieldInfos)) {
                    $continue = $fieldInfos['onForm'];
                }
                if (true === $continue) {
                    $form[] = Data::makeFormElement($key, null, $fieldInfos, $type, $hidden);
                }
            }
            return $form;
        }

        private function editForm($type, $object)
        {
            $model      = $this->model($type);
            $fields     = $model['fields'];
            $form       = array();
            foreach ($fields as $key => $fieldInfos) {
                $hidden = false;
                if (ake('hidden', $fieldInfos)) {
                    $hidden = $fieldInfos['hidden'];
                }
                if (ake('defaultValue', $fieldInfos)) {
                    $value = $fieldInfos['defaultValue'];
                }
                $continue = true;
                if (ake('onForm', $fieldInfos)) {
                    $continue = $fieldInfos['onForm'];
                }
                if (true === $continue) {
                    $form[] = Data::makeFormElement($key, $object->$key, $fieldInfos, $type, $hidden);
                }
            }
            return $form;
        }

        public function emptyCacheAction()
        {
            $type = request()->getType();
            if (false === can($type, 'empty_cache')) {
                $this->_noRight();
            }
            if (null !== $type) {
                if (ake($type, Data::$_settings)) {
                    Data::emptyCache($type);
                }
            }
            Router::redirect(URLSITE . 'backadmin/item/' . $type);
        }

        public function postDispatch()
        {

        }
    }
