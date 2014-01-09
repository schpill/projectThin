<?php
    namespace Thin;
    class staticController extends Controller
    {
        public function init()
        {
            $this->view->isIE = false;
            $this->view->isFF = false;
            if (strstr(Inflector::lower($_SERVER['HTTP_USER_AGENT']), 'msie')) {
                $this->view->isIE = true;
            }
            if (strstr(Inflector::lower($_SERVER['HTTP_USER_AGENT']), 'firefox')) {
                $this->view->isFF = true;
            }
            $this->request = request();
            $this->request->setUri($_SERVER['REQUEST_URI']);
            $session                = Session::instance('member');
            $cart                   = new Cart('Pilouf');
            $this->view->member     = $session->getMember();
            $this->view->cart       = $cart;
            $this->view->session    = session('searchProd');
        }

        public function preDispatch()
        {

        }

        public function languageAction()
        {

        }

        public function testAction()
        {

        }

        public function homeAction()
        {
            $session    = session('searchProd');
            $session->setField(null);
            $session->setFieldValue(null);
            $this->view->session    = $session;

            $query = '';

            $this->view->products   = Data::query('produit', $query);
            $this->view->title      = 'Accueil';
            // $route = new Route;
            // $route->setAction('test');
            // $route->setParams(array('time' => time()));
            // $this->forward($route);
        }

        public function searchAction()
        {
            $session    = session('searchProd');
            $field      = request()->getField();
            $fieldValue = request()->getFieldValue();
            $session->setField($field);
            $session->setFieldValue($fieldValue);

            $query = '';

            if (null !== $field && null !== $fieldValue) {
                switch ($field) {
                    case 'prodList':
                        if ('allprod' != $fieldValue) {
                            $query = 'etat = ' . $fieldValue;
                        }
                        break;
                    case 'catProdList':
                        $query = 'categorie = ' . $fieldValue;
                        break;
                    case 'colorProdList':
                        $query = 'color = ' . $fieldValue;
                        break;
                    case 'collProdList':
                        $query = 'collection = ' . $fieldValue;
                        break;
                }
            }

            $this->view->products = Data::query('produit', $query);
        }

        public function productAction()
        {
            $idProduct = request()->getProductId();
            if (null !== $idProduct) {
                $this->view->product = Data::getById('produit', $idProduct);
            }
        }

        public function cartAddAction()
        {
            $idProduct = request()->getProductId();
            if (null !== $idProduct) {
                $product = Data::getById('produit', $idProduct);
                $this->view->cart->add($idProduct, $product->getName(), 1, $product->getPriceL());
                Utils::go(URLSITE . 'cart.html');
            }
        }

        public function cartUpdateAction()
        {
            $rowId  = request()->getRowId();
            $action = request()->getAction();

            if (null !== $rowId && null !== $action) {
                $actionCart = '_' . $action . 'Cart';
                $this->$actionCart($rowId);
            }

            Utils::go(URLSITE . 'cart.html');
        }

        private function _addCart($rowId)
        {
            $row = $this->view->cart->get($rowId);
            if (null !== $row) {
                $qty = (int) $row->getQty();
                $newQty = $qty + 1;
                $this->view->cart->update($rowId, $newQty);
            }
        }

        private function _delCart($rowId)
        {
            $row = $this->view->cart->get($rowId);
            if (null !== $row) {
                $qty = (int) $row->getQty();
                $newQty = $qty - 1;
                $this->view->cart->update($rowId, $newQty);
            }
        }

        public function cartAction()
        {

        }

        public function buyAction()
        {

        }

        public function registerAction()
        {
            if (count($_POST)) {
                if (ake('email', $_POST)) {
                    $res = Data::query('client', 'email = ' . request()->getEmail());
                    if (!count($res)) {
                        $idMember = Data::add('client');
                        $member = Data::getById('client', $idMember);
                    } else {
                        $member = current($res);
                    }
                    $session = Session::instance('member');
                    $session->setMember($member);
                    $this->view->member = $session->getMember();
                    Utils::go(URLSITE . 'buy.html');
                }
            }
        }

        public function loginAction()
        {
            if (count($_POST)) {
                if (ake('email', $_POST)) {
                    $res = Data::query('client', 'password = ' . request()->getPassword() . ' && email = ' . request()->getEmail());
                    if (count($res)) {
                        $member = current($res);
                        $session = Session::instance('member');
                        $session->setMember($member);
                        $this->view->member = $session->getMember();
                    }
                }
            }
            Utils::go(URLSITE . 'buy.html');
        }

        public function postDispatch()
        {
        }
    }
