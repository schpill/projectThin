<?php
    namespace Thin;
    class CrudController extends Controller
    {
        public function init()
        {
            $export = request()->getCrudTypeExport();
            if (!empty($export)) {
                $this->noRender();
            } else {
                $request    = request();
                $entity     = $request->getEntity();
                $table      = $request->getTable();
                $em         = em($entity, $table);
                $this->view->config  = Crud::get('crud.' . get_class($em) . '.info');
                if (null === $this->view->config) {
                    $this->view->config = Crud::defaultConfig($em);
                }
            }
        }

        public function preDispatch()
        {

        }

        public function viewAction()
        {
            $request    = request();
            $entity     = $request->getEntity();
            $table      = $request->getTable();
            $id         = $request->getId();
            $em         = em($entity, $table);

            if (null !== $id) {
                $data   = array();
                $crud   = new Crud($em);
                $row    = $crud->read($id);
                $fields = $this->view->config['fields'];
                foreach ($fields as $field => $fieldInfos) {
                    if (ake('onView', $fieldInfos)) {
                        $viewvable = $fieldInfos['onView'];
                        if (true === $viewvable) {
                            $content = $fieldInfos['content'];
                            $value = $row[$field];
                            if (strstr($content, '##self##') || strstr($content, '##em##')) {
                                $content = repl(array('##self##', '##em##', '##field##'), array($value, $em, $field), $content);
                                $value = Crud::internalFunction($content);
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
                Utils::go404();
            }
        }

        public function listAction()
        {
            $request    = request();
            $entity     = $request->getEntity();
            $table      = $request->getTable();
            $em         = em($entity, $table);
            $list       = new Crud\Listing($em);

            $this->view->title          = $this->view->config['titleList'];
            $this->view->content        = $list->select()->render();
            $this->view->pagination     = $list->_pagination;
            $this->view->search         = $list->_search;
            $this->view->searchDisplay  = $list->_searchDisplay;
            $this->view->export         = $list->_export;
        }

        public function deleteAction()
        {
            $request    = request();
            $entity     = $request->getEntity();
            $table      = $request->getTable();
            $id         = $request->getId();
            $em         = em($entity, $table);

            if (null !== $id) {
                $crud = new Crud($em);
                $delete = $crud->delete($id);
                $redirect = URLSITE . 'admin/list/' . $request->getEntity() . '/' . $request->getTable();
                Utils::go($redirect);
            } else {
                Utils::go404();
            }
        }

        public function editAction()
        {
            $isPost     = count($_POST) ? true : false;
            $request    = request();
            $entity     = $request->getEntity();
            $table      = $request->getTable();
            $id         = $request->getId();
            $em         = em($entity, $table);
            if (null !== $id) {
                $fields = $this->view->config['fields'];
                if (true === $isPost) {
                    $crud = new Crud($em);
                    unset($_POST['submit']);
                    foreach ($fields as $field => $infos) {
                        if (ake('beforeInsert', $infos)) {
                            $content = repl(array('##self##', '##em##', '##field##'), array($_POST[$field], $em, $field), $infos['beforeInsert']);
                            $value = Html\Helper::display(Crud::internalFunction($content));
                            $_POST[$field] = $value;
                        }
                    }
                    $row = $crud->update($id, $_POST);
                    $redirect = URLSITE . 'admin/list/' . $request->getEntity() . '/' . $request->getTable();
                    Utils::go($redirect);
                } else {
                    $data = $em->find($id);
                    $tab = $data->toArray();
                    $form = array();
                    foreach ($tab as $key => $value) {
                        $fieldInfos = $fields[$key];
                        $hidden = ($key == $data->pk()) ? true : false;
                        $continue = true;
                        if (ake('onForm', $fieldInfos)) {
                            $continue = $fieldInfos['onForm'];
                        }
                        if (ake('hidden', $fieldInfos)) {
                            $hidden = $fieldInfos['hidden'];
                        }
                        if (true === $continue) {
                            $tmp = $form[] = Crud::makeFormElement($key, $value, $fieldInfos, $em, $hidden);
                        }
                    }

                    $this->view->form = $form;
                    $this->view->title = $this->view->config['titleEdit'];
                }
            } else {
                Utils::go404();
            }
        }

        public function duplicateAction()
        {
            $isPost     = count($_POST) ? true : false;
            $request    = request();
            $entity     = $request->getEntity();
            $table      = $request->getTable();
            $id         = $request->getId();
            $em         = em($entity, $table);
            $fields     = $this->view->config['fields'];

            if (false === $isPost && null === $id) {
                Utils::go404();
            }

            if (true === $isPost) {
                $crud = new Crud($em);
                unset($_POST['submit']);
                foreach ($fields as $field => $infos) {
                    if (ake('beforeInsert', $infos)) {
                        $content = repl(array('##self##', '##em##', '##field##'), array($_POST[$field], $em, $field), $infos['beforeInsert']);
                        $value = Html\Helper(Crud::internalFunction($content));
                        $_POST[$field] = $value;
                    }
                }
                $row = $crud->create($_POST);
                $redirect = URLSITE . 'admin/list/' . $request->getEntity() . '/' . $request->getTable();
                Utils::go($redirect);
            } else {
                $data = $em->find($id);
                $tab = $data->toArray();
                $form = array();
                foreach ($tab as $key => $value) {
                    $fieldInfos = $fields[$key];
                    if ($key != $em->pk()) {
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
                            $form[] = Crud::makeFormElement($key, $value, $fieldInfos, $em, $hidden);
                        }
                    }
                }

                $this->view->form = $form;
                $this->view->title = $this->view->config['titleAdd'];
            }
        }

        public function addAction()
        {
            $isPost     = count($_POST) ? true : false;
            $request    = request();
            $entity     = $request->getEntity();
            $table      = $request->getTable();
            $em         = em($entity, $table);
            $fields = $this->view->config['fields'];
            if (true === $isPost) {
                $crud = new Crud($em);
                unset($_POST['submit']);
                foreach ($fields as $field => $infos) {
                    if (ake('beforeInsert', $infos)) {
                        $content = repl(array('##self##', '##em##', '##field##'), array($_POST[$field], $em, $field), $infos['beforeInsert']);
                        $value = Html\Helper(Crud::internalFunction($content));
                        $_POST[$field] = $value;
                    }
                }
                $row = $crud->create($_POST);
                $redirect = URLSITE . 'admin/list/' . $request->getEntity() . '/' . $request->getTable();
                Utils::go($redirect);
            } else {
                $form = array();
                foreach ($fields as $key => $fieldInfos) {
                    if ($key != $em->pk()) {
                        $hidden = false;
                        if (ake('hidden', $fieldInfos)) {
                            $hidden = $fieldInfos['hidden'];
                        }
                        $value = null;
                        if (ake('defaultValue', $fieldInfos)) {
                            $value = $fieldInfos['defaultValue'];
                        }
                        $continue = true;
                        if (ake('onForm', $fieldInfos)) {
                            $continue = $fieldInfos['onForm'];
                        }
                        if (true === $continue) {
                            $form[] = Crud::makeFormElement($key, $value, $fieldInfos, $em, $hidden);
                        }
                    }
                }

                $this->view->form = $form;
                $this->view->title = $this->view->config['titleAdd'];
            }
        }

        public function postDispatch()
        {

        }
    }
