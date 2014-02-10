<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'hierarchy'             => array(
                'label'             => 'Ordre',
                'default'           => 'auto',
                'checkValue'        => function ($val) {
                    if ('auto' == $val) {
                        $pages = \Thin\Cms::getPages();
                        return count($pages) + 1;
                    }
                    return $val;
                },
            ),
            'menu'                  => array(
                'label'             => 'Libellé menu',
                'isTranslated'      => true,
                'notSearchable'     => true,
                'noList'            => true,
                'notExportable'     => true,
            ),
            'url'                   => array(
                'label'             => 'URL',
                'isTranslated'      => true,
                'notSearchable'     => true,
                'noList'            => true,
                'notExportable'     => true,
            ),
            'date_out'              => array(
                'label'             => 'Date de dépublication',
                'type'              => 'date',
                'noList'            => true,
                'canBeNull'         => true,
                'notRequired'       => true,
            ),
            'statuspage'            => array(
                'type'              => 'data',
                'entity'            => 'statuspage',
                'sortOrder'         => 'DESC',
                'fields'            => array('name'),
                'sort'              => 'name',
                'default'           => getStatus('online')->getId(),
                'label'             => 'Statut',
                'contentList'       => array('getValueEntity', 'statuspage', 'name'),
                'canBeNull'         => true,
                'notRequired'       => true,
            ),
            'template'              => array(
                'label'             => 'Template de page',
                'default'           => 'page',
                'noList'            => true
            ),
            'is_home'               => array(
                'type'              => 'data',
                'entity'            => 'bool',
                'fields'            => array('name'),
                'default'           => getBool('false')->getId(),
                'sort'              => 'name',
                'sortOrder'         => 'DESC',
                'label'             => 'Homepage',
                'contentList'       => array('getValueEntity', 'bool', 'name'),
                'norel'             => true,
            ),
            'parent'                => array(
                'type'              => 'data',
                'entity'            => 'page',
                'fields'            => array('name'),
                'sort'              => 'hierarchy',
                'label'             => 'Page parent',
                'contentList'       => array('getValueEntity', 'page', 'name'),
                'norel'             => true,
                'canBeNull'         => true,
                'notRequired'       => true,
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les hooks */
            'afterStore'            => function($type, $data) {
                $obj = new Obj;
                $obj->populate($data);
                $template = strtolower($obj->getTemplate());
                $viewFile   = APPLICATION_PATH . DS . SITE_NAME . DS . 'modules' . DS . 'www' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . $template . '.phtml';
                if (!\Thin\File::exists($viewFile)) {
                    $cnt = fgc(APPLICATION_PATH . DS . SITE_NAME . DS . 'modules' . DS . 'www' . DS . 'views' . DS . 'scripts' . DS . 'static' . DS . 'page.phtml');
                    \Thin\File::put($viewFile, $cnt);
                }
            },
            /* les indexes */
            'indexes'               => array(
                'statuspage'        => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'statuspage'        => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'orderList'             => 'hierarchy',
            'orderListDirection'    => 'ASC'
        ),
    );
