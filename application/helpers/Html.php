<?php
    namespace ThinHelper;
    use Thin\Data;
    use Thin\Arrays;
    use Thin\Inflector;
    use Thin\Querydata;
    class Html
    {
        private static $fgc = null;

        public static function url()
        {
            return substr(URLSITE, 0, -1) . $_SERVER['REQUEST_URI'];
        }

        public static function isPage($page)
        {
            $url = static::url();
            return strstr($url, $page) ? true : false;
        }

        public static function isPost()
        {
            if (count($_POST)) {
                if (!ake('app_language', $_POST) && !ake('cms_language', $_POST)) {
                    return true;
                }
            }
            return false;
        }

        public static function isError()
        {
            return (strstr($_SERVER['REQUEST_URI'], '?error')) ? true : false;
        }

        public static function isProd()
        {
            return (strstr($_SERVER["SERVER_NAME"], 'pilouf.com')) ? true : false;
        }

        public static function formUploadImage($label, $id, $required = false, $value = null, $type = '')
        {
            $require = (true === $required) ? 'required' : '';
            $html = '
                                <div class="control-group">
                                    <label class="control-label" for="' . $id . '">' . $label . '</label>
                                    <div class="controls">
                                        <iframe id="iframe_' . $id . '" style="height: 75px; border: none;" class="span8" src="' . URLSITE . 'assets/js/upload2.php?field=' . $id . '&type=' . $type . '"></iframe>
                                        <input ' . $require . ' type="hidden" name="' . $id . '" id="' . $id . '" value="' . $value . '" />';
            if (null !== $value) {
                if (strlen($value)) {
                    $html .= '<img id="' . $id . '_img" src="' . $value . '" />&nbsp;&nbsp;<a class="button" onclick="$(\'#' . $id . '_img\').hide(); $(\'#' . $id . '\').val(\'\'); return false;"><i class="icon-trash"></i></a>';
                } else {
                    $html .= '<img id="' . $id . '_img" style="display: none;" />';
                }
            } else {
                $html .= '<img id="' . $id . '_img" style="display: none;" />';
            }
            $html .= '</div>
                                </div>';
            echo $html;
        }

        public static function formUploadFile($label, $id, $required = false, $value = null, $type = '')
        {
            $require = (true === $required) ? 'required' : '';
            $ifrCss = (strlen($value)) ? 'display: none;' : '';
            $html = '
                                <div class="control-group">
                                    <label class="control-label" for="' . $id . '">' . $label . '</label>
                                    <div class="controls">
                                        <iframe id="iframe_' . $id . '" style="height: 75px; border: none;' . $ifrCss . '" class="span8" src="' . URLSITE . 'assets/js/file_upload2.php?field=' . $id . '&type=' . $type . '"></iframe>
                                        <input ' . $require . ' type="hidden" name="' . $id . '" id="' . $id . '" value="' . $value . '" />';
            if (null !== $value) {
                if (strlen($value)) {
                    $tab = explode('/', $value);
                    $nameDoc = Arrays::last($tab);
                    $tab = explode('_', $nameDoc);
                    $nameDoc = repl(Arrays::first($tab) . '_', '', $nameDoc);
                    $html .= '<p /><div id="' . $id . '_file"><a href="' . $value . '" target="_file">' . $nameDoc . '</a>&nbsp;&nbsp;<a class="button" onclick="$(\'#' . $id . '_file\').hide(); $(\'#' . $id . '\').val(\'\'); $(\'#iframe_' . $id . '\').show(); return false;" href="#"><i class="icon-trash"></i></a></div>';
                } else {
                    $html .= '<div id="' . $id . '_file" style="display: none;"></div>';
                }
            } else {
                $html .= '<div id="' . $id . '_file" style="display: none;"></div>';
            }
            $html .= '</div>
                                </div>';
            echo $html;
        }

        public static function options($type, $item, $plus = '')
        {
            $options = '';
            if (can($type, 'view')) {
                $options .= '<td class="pull-center" style="text-align: center; font-size: 120%;"><a href="' . URLSITE . 'backadmin/item_view/' . $type . '/' . $item->getId() . '/' . static::makeKey($item->getId()) . '"><i title="afficher" class="icon-file"></i></a>&nbsp;&nbsp;&nbsp;';
            }
            if (can($type, 'duplicate')) {
                $options .= '<a href="' . URLSITE . 'backadmin/item_duplicate/' . $type . '/' . $item->getId() . '/' . static::makeKey($item->getId()) . '"><i title="dupliquer" class="icon-copy"></i></a>&nbsp;&nbsp;&nbsp;';
            }
            if (can($type, 'edit')) {
                $options .= '<a href="' . URLSITE . 'backadmin/item_edit/' . $type . '/' . $item->getId() . '/' . static::makeKey($item->getId()) . '"><i title="éditer" class="icon-edit"></i></a>&nbsp;&nbsp;&nbsp;';
            }
            if (!strlen($plus)) {
                if (can($type, 'delete')) {
                    $options .= '<a href="#" onclick="if (confirm(\'Confirmez-vous la suppression de cet élément ?\')) document.location.href = \'' . URLSITE . 'backadmin/item_delete/' . $type . '/' . $item->getId() . '/' . static::makeKey($item->getId()) . '\'; return false;"><i title="supprimer" class="icon-trash"></i></a></td>';
                }
            } else {
                if (can($type, 'delete')) {
                    $options .= '<a href="#" onclick="if (confirm(\'Confirmez-vous la suppression de cet élément ?\')) document.location.href = \'' . URLSITE . 'backadmin/item_delete/' . $type . '/' . $item->getId() . '/' . static::makeKey($item->getId()) . '\'; return false;"><i title="supprimer" class="icon-trash"></i></a>' . $plus . '</td>';
                }
            }
            return $options;
        }

        public static function makeKey($value)
        {
            if (null === static::$fgc) {
                static::$fgc = fgc(__file__);
            }
            return sha1($value . date('dmY') . static::$fgc);
        }

        public static function checkKey($value, $key)
        {
            $goodKey = static::makeKey($value);
            return $goodKey === $key;
        }

        public static function formSelectEntity(array $config)
        {
            $type       = $config['entity'];
            $db         = new Querydata($type);
            if (!ake('sortOrder', $config)) {
                $data   = $db->all()->order($config['sort'])->get();
            } else {
                $data   = $db->all()->order($config['sort'], $config['sortOrder'])->get();
            }
            $settings   = ake($type, Data::$_settings) ? Data::$_settings[$type] : array();
            $require    = (true === $config['required']) ? 'required' : '';
            $val        = (ake($config['id'], $_POST)) ? $_POST[$config['id']] : '';

            if (ake('value', $config)) {
                $val = $config["value"];
            }

            $html = '<div class="control-group">';
            $html .= '<label class="control-label" for="' . $config['id'] . '">' . $config['label'] . '</label>';
            $html .= '<div class="controls">';
            $html .= '<select ' . $require . ' id="' . $config['id'] . '" name="' . $config['id'] . '">';
            $html .= '<option value="">Choisir</option>';
            if (count($data)) {
                $fields = $config['fields'];
                foreach ($data as $item) {
                    $itemId = $item->getId();
                    $option = '';
                    foreach ($fields as $field) {
                        $option .= $item->$field . ' ';
                    }
                    $option = substr($option, 0, -1);
                    if ($val == $itemId)  {
                        $html .= '<option selected value="' . $itemId . '">' . $option . '</option>';
                    } else {
                        $html .= '<option value="' . $itemId . '">' . $option . '</option>';
                    }
                }
            }
            $html .= '</select>';
            $html .= '</div>';
            $html .= '</div>';
            echo $html;
        }

        public static function formSearchSelectEntity(array $config)
        {
            $type       = $config['entity'];
            $db         = new Querydata($type);
            if (!ake('sortOrder', $config)) {
                $data   = $db->all()->order($config['sort'])->get();
            } else {
                $data   = $db->all()->order($config['sort'], $config['sortOrder'])->get();
            }

            $html = '<select id="' . $config['id'] . '">';
            $html .= '<option value="">Choisir</option>';
            if (count($data)) {
                $fields = $config['fields'];
                foreach ($data as $item) {
                    $itemId = $item->getId();
                    $option = '';
                    foreach ($fields as $field) {
                        $option .= $item->$field . ' ';
                    }
                    $option = substr($option, 0, -1);
                    $html .= '<option value="' . $itemId . '">' . $option . '</option>';
                }
            }
            $html .= '</select>';
            return $html;
        }

        public static function listTable($type, $data, $fields)
        {
            $settings       = ake($type, Data::$_settings) ? Data::$_settings[$type] : array();
            $fieldsModel    = Data::$_fields[$type];

            $page           = (null === request()->getPage()) ? 1 : request()->getPage();
            $order          = (null === request()->getOrder()) ? (ake('orderList', $settings)) ? $settings['orderList'] : 'date_create' : request()->getOrder();
            $orderDirection = (null === request()->getOrderDirection()) ? (ake('orderListDirection', $settings)) ? $settings['orderListDirection'] : 'DESC' : request()->getOrderDirection();


            $html = '<form action="' . URLSITE . 'backadmin/item/' . $type . '" id="listForm" method="post">
            <input type="hidden" name="page" id="page" value="' . $page . '" /><input type="hidden" name="order" id="order" value="' . $order . '" /><input type="hidden" name="order_direction" id="order_direction"  value="' . $orderDirection . '" /><input type="hidden" id="where" name="where" value="' . \Thin\Crud::checkEmpty('where') .'" /><input type="hidden" id="type_export" name="type_export" value="" />
            <table style="clear: both;" class="table table-striped tablesorter table-bordered table-condensed table-hover">
                        <thead>
                        <tr>';
            foreach ($fields as $field => $fieldInfos) {
                $fieldSettings = $fieldsModel[$field];
                if (ake('notSortable', $fieldSettings)) {
                    $html .= '<th>'. \Thin\Html\Helper::display($fieldInfos['label']) . '</th>';
                } else {
                    if ($field == $order) {
                        $directionJs = ('ASC' == $orderDirection) ? 'DESC' : 'ASC';
                        $js = 'orderGoPage(\'' . $field . '\', \'' . $directionJs . '\');';
                        $html .= '<th><div onclick="' . $js . '" class="text-left field-sorting ' . Inflector::lower($orderDirection) . '" rel="' . $field . '">'. \Thin\Html\Helper::display($fieldInfos['label']) . '</div></th>';
                    } else {
                        $js = 'orderGoPage(\'' . $field . '\', \'ASC\');';
                        $html .= '<th><div onclick="' . $js . '" class="text-left field-sorting" rel="' . $field . '">'. \Thin\Html\Helper::display($fieldInfos['label']) . '</div></th>';
                    }
                }
            }
            $html .= '<th style="text-align: center;">Action</th>
                        </tr>
                        </thead>
                        <tbody>';
            foreach ($data as $item) {
                $html .= '<tr ondblclick="document.location.href = \''.URLSITE.'backadmin/item_edit/' . $type . '/' . $item->getId() . '/' . static::makeKey($item->getId()) . '\';">';
                foreach ($fields as $field => $fieldInfos) {
                    $value = (!empty($item->$field)) ? $item->$field : null;
                    if (!ake('content', $fieldInfos)) {
                        $html .= '<td>'. \Thin\Html\Helper::display($value) . '</td>';
                    } else {
                        list($f, $e, $v) = $fieldInfos['content'];
                        if (isset($item->$field)) {
                            $value = \ThinService\Admin::$f($item->$field, $e, $v);
                        }
                        $html .= '<td>'. \Thin\Html\Helper::display($value) . '</td>';
                    }
                }
                $html .= static::options($type, $item);
                $html .= '</tr>';
            }
            $html .= '</tbody>
                    </table></form></div>';
            echo $html;
        }

        public static function makeSearch($type)
        {
            $settings       = ake($type, Data::$_settings) ? Data::$_settings[$type] : array();
            $fields         = Data::$_fields[$type];
            $where          = (!strlen(request()->getWhere())) ? '' : \Thin\Crud::makeQueryDataDisplay(request()->getWhere(), $type);
            $search         = '<div class="span10">' . NL;

            if (!empty($where)) {
                $search .= '<span class="badge badge-success">Recherche en cours : ' . $where . '</span>';
                $search .= '&nbsp;&nbsp;<a class="btn btn-warning" href="#" onclick="document.location.href = document.URL;"><i class="icon-trash icon-white"></i> Supprimer cette recherche</a>&nbsp;&nbsp;';
            }
            $search .= '<button id="newCrudSearch" type="button" class="btn btn-info" onclick="$(\'#crudSearchDiv\').slideDown();$(\'#newCrudSearch\').hide();$(\'#hideCrudSearch\').show();"><i class="icon-search icon-white"></i> Effectuer une nouvelle recherche</button>';
            $search .= '&nbsp;&nbsp;<button id="hideCrudSearch" type="button" style="display: none;" class="btn btn-danger" onclick="$(\'#crudSearchDiv\').slideUp();$(\'#newCrudSearch\').show();$(\'#hideCrudSearch\').hide();">Masquer la recherche</button>';
            $search .= '<fieldset id="crudSearchDiv" style="display:none;">' . NL;

            $search .= '<hr />' . NL;

            $i = 0;
            $fieldsJs = array();
            $js = '<script type="text/javascript">' . NL;
            foreach ($fields as $field => $infosField) {
                $label = (ake('label', $infosField)) ? $infosField['label'] : ucfirst(Inflector::lower($field));
                if (!ake('notSearchable', $infosField)) {
                    $fieldsJs[] = "'$field'";
                    $search .= '<div class="control-group">' . NL;
                    $search .= '<label class="control-label">' . \Thin\Html\Helper::display($label) . '</label>' . NL;
                    $search .= '<div class="controls" id="crudControl_' . $i . '">' . NL;
                    $search .= '<select style="width: 250px;" id="crudSearchOperator_' . $i . '">
                    <option value="=">=</option>
                    <option value="LIKE">Contient</option>
                    <option value="NOT LIKE">Ne contient pas</option>
                    <option value="START">Commence par</option>
                    <option value="END">Finit par</option>
                    <option value="<">&lt;</option>
                    <option value=">">&gt;</option>
                    <option value="<=">&le;</option>
                    <option value=">=">&ge;</option>
                    </select>' . NL;
                    $contentSearch = ake('type', $infosField);
                    if (false === $contentSearch) {
                        $search .= '<input style="width: 40%;" type="text" id="crudSearchValue_' . $i . '" value="" />';
                    } else {
                        if ('data' == $infosField['type']) {
                            $confData  = \ThinHelper\Html::formSearchSelectEntity(
                                array(
                                    'entity'    => $infosField['entity'],
                                    'id'        => 'crudSearchValue_' . $i,
                                    'label'     => $label,
                                    'sort'      => $infosField['sort'],
                                    'fields'    => $infosField['fields']
                                )
                            );
                            $search  .= repl('<select ', '<select style="width: 40%;" ', $confData);
                        } elseif ('custom' == $infosField['type'] && ake('customSearch', $infosField)) {
                            $search  .= Data::evaluate($infosField['customSearch'], array('i' => $i));
                        } else {
                            $search .= '<input style="width: 40%;" type="text" id="crudSearchValue_' . $i . '" value="" />';
                        }
                    }
                    $search .= '&nbsp;&nbsp;<span class="btn btn-success" href="#" onclick="addRowSearch(\'' . $field . '\', ' . $i . '); return false;"><i class="icon-plus"></i></span>';
                    $search .= '</div>' . NL;
                    $search .= '</div>' . NL;
                    $i++;
                }
            }
            $js .= 'var searchFields = [' . implode(', ', $fieldsJs)  . ']; var numFieldsSearch = ' . ($i - 1) . ';';
            $js .= '</script>' . NL;
            $search .= '<div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary" name="Rechercher" onclick="makeCrudSearch();">Rechercher</button>
                </div>
            </div>' . NL;
            $search .= '</fieldset>' . NL;
            $search .= '</div>
        <div class="span2 clear"></div>' . NL . $js . NL;
            return $search;
        }

        public static function getValueEntity($id, $entity, $fields)
        {
            $return = '';
            $item = Data::getById($entity, $id);
            if (null === $item) {
                return $return;
            }
            $fields = explode(',', $fields);
            foreach ($fields as $field) {
                $return .= $item->$field . ' ';
            }
            return substr($return, 0, -1);
        }

        public static function getValueVocabulary($id, array $data, array $config = array())
        {
            foreach ($data as $key => $value) {
                if ($id == $key) {
                    return $value;
                }
            }
            return '';
        }
    }
