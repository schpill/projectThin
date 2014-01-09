<?php
    namespace Thin;
    class projectController extends Controller
    {
        public function init()
        {
            $tab = explode('/', $_SERVER['REQUEST_URI']);
            $type = end($tab);
            if (!in_array($type, array('login', 'logout'))) {
                $session = $this->checkSession();
            }

            $action = $tab[count($tab) - 3];

            if (in_array($action, array('edit', 'duplicate', 'delete', 'view'))) {
                $type = $tab[count($tab) - 2];
            }
            $file = APPLICATION_PATH . DS . 'entities' . DS . 'project' . DS . ucfirst(Inflector::lower($type)) . '.php';
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
        }

        public function preDispatch()
        {

        }

        public function addAction()
        {
            $tab = explode('/', $_SERVER['REQUEST_URI']);

            $type = end($tab);

            if (count($_POST)) {
                Project::add($type);
            }

            $this->view->title = $this->view->config['titleAdd'];
            $this->view->type = $type;
            $this->view->fields = $this->addForm($type);
        }

        public function viewAction()
        {
            $tab = explode('/', $_SERVER['REQUEST_URI']);
            $this->view->id = $id = end($tab);

            if (null !== $id) {
                $this->view->type = $type = $tab[count($tab) - 2];
                $object = Project::getById($type, $id);
                $data   = array();
                $fields = $this->view->config['fields'];
                foreach ($fields as $field => $fieldInfos) {
                    if (ake('onView', $fieldInfos)) {
                        $viewvable = $fieldInfos['onView'];
                        if (true === $viewvable) {
                            $content = $fieldInfos['content'];
                            $value = $object->$field;
                            if (strstr($content, '##self##') || strstr($content, '##type##') || strstr($content, '##field##')) {
                                $content = repl(array('##self##', '##type##', '##field##'), array($value, $type, $field), $content);
                                $value = Project::internalFunction($content);
                            }
                            if (empty($value)) {
                                $value = '&nbsp;';
                            }
                            $data[Html\Helper::display($fieldInfos['label'])] = $value;
                        }
                    }
                }
                $this->view->data   = $data;
                $this->view->title  = $this->view->config['titleView'];
            } else {
                Utils::go(URLSITE . 'project/list/' . $type);
            }
        }

        public function editAction()
        {
            $tab = explode('/', $_SERVER['REQUEST_URI']);
            $this->view->id = $id = end($tab);
            $this->view->type = $type = $tab[count($tab) - 2];
            $object = Project::getById($type, $id);

            if (count($_POST)) {
                Project::edit($type, $id);
            }
            $this->view->session = $this->checkSession();
            $this->view->fields = $this->editForm($type, $object);

            $this->view->title = $this->view->config['titleEdit'];
        }

        public function deleteAction()
        {
            $tab = explode('/', $_SERVER['REQUEST_URI']);
            $this->view->id = $id = end($tab);
            $this->view->type = $type = $tab[count($tab) - 2];

            Project::delete($type, $id);
            Utils::go(URLSITE . 'project/list/' . $type);
        }

        public function listAction()
        {
            $tab = explode('/', $_SERVER['REQUEST_URI']);
            $list = new Listing(end($tab));

            $this->view->title          = $this->view->config['titleList'];
            $this->view->content        = $list->select()->render();
            $this->view->type           = end($tab);
            $this->view->pagination     = $list->_pagination;
            $this->view->search         = $list->_search;
            $this->view->searchDisplay  = $list->_searchDisplay;
            $this->view->export         = $list->_export;
        }

        public function logoutAction()
        {
            $_SESSION = array();
            Utils::go(URLSITE . 'project/login');
        }

        public function loginAction()
        {
            $request = request();
            $username = $request->getUsername();
            $password = $request->getPassword();
            if (!empty($username) && !empty($password)) {
                $error = \ThinService\Acl::check($username, $password, 'project');
                if (false === $error) {
                    Utils::go(URLSITE . 'project/dashboard');
                }
            }
            $this->view->title = 'Se connecter';
            $this->view->activeNews = 'active';
        }

        public function dashboardAction()
        {
            $session = $this->checkSession();
            $this->view->title = 'Tableau de bord';
            $this->view->user = $session->getUser();
            $this->view->types = $session->getUser()->getPages();
            $this->view->remain = round(100 - ((31 - date('d')) * 2.06), 2);
        }

        private function checkSession()
        {
            $session = Session::instance('project');
            if (null === $session->getUser()) {
                Utils::go(URLSITE . 'project/login');
            }
            return $session;
        }

        private function model($type)
        {
            $file = APPLICATION_PATH . DS . 'entities' . DS . 'project' . DS . ucfirst(Inflector::lower($type)) . '.php';
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
                    $form[] = Project::makeFormElement($key, null, $fieldInfos, $type, $hidden);
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
                    $form[] = Project::makeFormElement($key, $object->$key, $fieldInfos, $type, $hidden);
                }
            }
            return $form;
        }

        public function postDispatch()
        {

        }
    }
