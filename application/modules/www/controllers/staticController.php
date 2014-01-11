<?php
    namespace Thin;
    class staticController extends Controller
    {
        public function init()
        {
            $this->view->isIE       = false;
            $this->view->isFF       = false;
            $this->view->isChrome   = false;
            $this->view->isOpera    = false;
            if (strstr(Inflector::lower($_SERVER['HTTP_USER_AGENT']), 'msie')) {
                $this->view->isIE = true;
            }
            if (strstr(Inflector::lower($_SERVER['HTTP_USER_AGENT']), 'firefox')) {
                $this->view->isFF = true;
            }
            if (strstr(Inflector::lower($_SERVER['HTTP_USER_AGENT']), 'chrome')) {
                $this->view->isChrome = true;
            }
            if (strstr(Inflector::lower($_SERVER['HTTP_USER_AGENT']), 'opera')) {
                $this->view->isOpera = true;
            }
            $this->request = request();
            $this->request->setUri($_SERVER['REQUEST_URI']);
            $this->view->session    = session(container()->getModule());
        }

        public function preDispatch()
        {

        }


        public function homeAction()
        {
            $this->view->title      = 'Accueil';
        }

        public function postDispatch()
        {
        }
    }
