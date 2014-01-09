<?php
    namespace ThinModel\Admin;
    use Thin\Admin as Admin;

    class Product
    {
        private $_config;
        private $_types;
        private $_desc;
        private $_request;
        private $_items;
        public  $_pagination        = null;
        public  $_search            = null;
        public  $_searchDisplay     = null;
        public  $_export            = array();

        public function listing()
        {
            $model          = Admin::getFields('products');
            $this->_request = request();
            $this->_config  = $model['infos'];
            $this->_type    = 'product';

            $this->_items = Admin::query($this->_type);

            if (!count($this->_items)) {
                return '<div class="span4"><div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button>' . $this->_config['noResultMessage'] . '</div></div>';
            }

            $pagination = $this->_config['pagination'];
            $fields     = $model['fields'];
            $addable    = $this->_config['addable'];
            $viewable   = $this->_config['viewable'];
            $editable   = $this->_config['editable'];
            $deletable  = $this->_config['deletable'];
            $duplicable = $this->_config['duplicable'];

            if (ake('export', $this->_config)) {
                $export     = $this->_config['export'];

                if (count($export)) {
                    $this->_export = $export;
                }
            }

            $order          = (!strlen($this->_request->getCrudOrder())) ? $this->_config['defaultOrder'] : $this->_request->getCrudOrder();
            $orderDirection = (!strlen($this->_request->getCrudOrderDirection())) ? $this->_config['defaultOrderDirection'] : $this->_request->getCrudOrderDirection();

            $sorted = (true === $this->_config['order']) ? 'tablesorter' : '';

            $html = '<table class="table table-striped ' . $sorted . ' table-bordered table-condensed">' . NL;
            $html .= '<thead>' . NL;
            $html .= '<tr>' . NL;
            foreach ($fields as $field => $infosField) {
                if (true === $infosField['onList']) {
                    if (true !== $infosField['sortable']) {
                        $html .= '<th class="no-sorter">' . \Thin\Html\Helper::display($infosField['label']) . '</th>' . NL;
                    } else {
                        if ($field == $order) {
                            $directionJs = ('ASC' == $orderDirection) ? 'DESC' : 'ASC';
                            $js = 'orderGoPage(\'' . $field . '\', \'' . $directionJs . '\');';
                            $html .= '<th>
                                <div onclick="' . $js . '" class="text-left field-sorting ' . \Thin\Inflector::lower($orderDirection) . '" rel="' . $field . '">
                                ' . \Thin\Html\Helper::display($infosField['label']) . '
                                </div>
                            </th>';
                        } else {
                            $js = 'orderGoPage(\'' . $field . '\', \'ASC\');';
                            $html .= '<th>
                                <div onclick="' . $js . '" class="text-left field-sorting" rel="' . $field . '">
                                ' . \Thin\Html\Helper::display($infosField['label']) . '
                                </div>
                            </th>';
                        }
                    }
                }
            }
            $html .= '<th class="no-sorter">Actions</th>' . NL;
            $html .= '</tr>' . NL;
            $html .= '</thead>' . NL;
            $html .= '<tbody>' . NL;
            foreach ($this->_items as $item) {
                dieDump($item);
                $html .= '<tr>' . NL;
                foreach ($fields as $field => $infosField) {
                    if (true === $infosField['onList']) {
                        $content = $infosField['content'];
                        $options = (ake('options', $infosField)) ? $infosField['options'] : array();
                        if (empty($options)) {
                            $options = array();
                        }
                        if (!in_array('nosql', $options)) {
                            $getter = 'get' . \Thin\Inflector::camelize($field);
                            $value = $item->$getter();
                        } else {
                            $value = $content;
                        }
                        if (strstr($content, '##self##') || strstr($content, '##em##') || strstr($content, '##field##') || strstr($content, '##id##')) {
                            $content = repl(array('##self##', '##type##', '##field##', '##id##'), array($value, $this->_type, $field, $item->getId()), $content);
                            $value = Admin::internalFunction($content);
                        }
                        if (empty($value)) {
                            $value = '&nbsp;';
                        }
                        $html .= '<td>'. \Thin\Html\Helper::display($value) . '</td>' . NL;
                    }
                }

                $actions = '';

                if (true === $viewable) {
                    $actions .= '<a href="'. URLSITE . 'admin/views/'.$this->_type.'s/'.$item->getId().'"><i title="afficher" class="icon-file"></i></a>&nbsp;&nbsp;&nbsp;';
                }

                if (true === $editable) {
                    $actions .= '<a href="'. URLSITE . 'admin/edits/'.$this->_type.'s/'.$item->getId().'"><i title="éditer" class="icon-edit"></i></a>&nbsp;&nbsp;&nbsp;';
                }

                if (true === $duplicable) {
                    $actions .= '<a href="'. URLSITE . 'admin/duplicates/'.$this->_type.'s/'.$item->getId().'"><i title="dupliquer" class="icon-plus"></i></a>&nbsp;&nbsp;&nbsp;';
                }

                if (true === $deletable) {
                    $actions .= '<a href="#" onclick="if (confirm(\'Confirmez-vous la suppression de cet élément ?\')) document.location.href = \''. URLSITE . 'admin/deletes/'.$this->_type.'s/'.$item->getId().'\';"><i title="supprimer" class="icon-trash"></i></a>&nbsp;&nbsp;&nbsp;';
                }

                $html .= '<td class="col_plus">' . $actions . '</td>' . NL;
                $html .= '</tr>' . NL;
            }
            $html .= '</tbody>' . NL;
            $html .= '</table>' . NL;
            return $html;
        }

        public function add()
        {
            $isPost     = count($_POST) ? true : false;
            if (true === $isPost) {
                Admin::add('product');
            }
            $model      = Admin::getFields('products');
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
                    $form[] = Admin::makeFormElement($key, null, $fieldInfos, 'product', $hidden);
                }
            }
            return array($form, $model['infos']);
        }

        public function edit($id)
        {

        }

        public function view($id)
        {

        }
    }
