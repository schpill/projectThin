<?php
    namespace Thin;
    class apiController extends Controller
    {
        private $_actionArgs = array();
        private $_apiRequest;

        public function init()
        {

        }

        public function preDispatch()
        {

        }

        public function routeAction()
        {
            $api = new Api();
            $auth = $api->auth($this->_request()->getResource(), $this->_request()->getKey());
            if (false === $auth) {
                $this->_render(
                    array(
                        'code'      => 403,
                        'message'   => 'Invalid key and / or resource'
                    ),
                    '403 Unauthorized'
                );
            }

            if (null === $this->_request()->getUri()) {
                $this->_render(
                    array(
                        'code'      => 404,
                        'message'   => 'Invalid action'
                    ),
                    '404 Not Found'
                );
            }

            $uri     = explode('/', $this->_request()->getUri());
            $actions = get_class_methods(get_class($this));
            $action  = Inflector::lower($this->_request()->getResource()) . ucfirst(current($uri)) . 'Action';
            if (!Arrays::inArray($action, $actions)) {
                $this->_render(
                    array(
                        'code'      => 404,
                        'message'   => 'Invalid action'
                    ),
                    '404 Not Found'
                );
            }
            $uriString = $this->_request()->getUri();
            if (1 < count($uri)) {
                $uri = repl(current($uri) . '/', '', $uriString);
            } else {
                $uri = repl(current($uri), '', $uriString);
            }
            $this->_actionArgs = explode('/', $uri);
            return $this->$action();
        }

        public function eavSetAction()
        {
            $entity = current($this->_actionArgs);
            $data = end($this->_actionArgs);
            if (2 <> count($this->_actionArgs) or empty($entity) or empty($data)) {
                $this->_render(
                    array(
                        'code'      => 404,
                        'message'   => 'Invalid action'
                    ),
                    '404 Not Found'
                );
            }
            $tab = unserialize(base64_decode($data));
            $id = Eavdata::add($entity, $tab);
            $this->_render(
                array(
                    'code'      => 200,
                    'id'        => $id
                )
            );
        }

        public function eavGetAction()
        {
            $id = current($this->_actionArgs);
            if (1 <> count($this->_actionArgs) or empty($id)) {
                $this->_render(
                    array(
                        'code'      => 404,
                        'message'   => 'Invalid action'
                    ),
                    '404 Not Found'
                );
            }
            $object = Eavdata::getById($id);

            if (null === $object) {
                $this->_render(
                    array(
                        'code'      => 404,
                        'message'   => 'no data'
                    ),
                    '404 Not Found'
                );
            }

            $row = Eavdata::returnArray($object);
            $this->_render(
                array(
                    'code'      => 200,
                    'data'      => $row
                )
            );
        }

        public function eavDeleteAction()
        {
            $id = current($this->_actionArgs);
            if (1 <> count($this->_actionArgs) or empty($id)) {
                $this->_render(
                    array(
                        'code'      => 404,
                        'message'   => 'Invalid action'
                    ),
                    '404 Not Found'
                );
            }
            $delete = Eavdata::delete($id);

            if (false === $delete) {
                $this->_render(
                    array(
                        'code'      => 500,
                        'message'   => 'delete action error'
                    ),
                    '500 Error'
                );
            }

            $this->_render(
                array(
                    'code'      => 200,
                    'data'      => 'data has been deleted'
                )
            );
        }

        private function _render($str, $status = '200 OK')
        {
            header("HTTP/1.1 {$status}");
            header('Content-Type: application/json');
            die(json_encode($str));
        }

        private function _request()
        {
            if (null === $this->_apiRequest) {
                $r = new ApiRequest;
                $rUri = repl('api/', '', substr($_SERVER['REQUEST_URI'], 1, strlen($_SERVER['REQUEST_URI'])));
                $tab = explode('/', $rUri);
                $r->setResource(current($tab));
                $r->setKey($tab[1]);
                $uri = repl(current($tab) . '/' . $tab[1] . '/', '', $rUri);
                $r->setUri($uri);
                $this->_apiRequest = $r;
            }
            return $this->_apiRequest;
        }

        public function postDispatch()
        {

        }
    }
