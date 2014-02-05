<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'hierarchy'             => array(
                'label'             => 'Ordre',
                'checkValue'        => function ($val) {
                    if (is_numeric($val)) {
                        return $val;
                    }
                    return '1';
                },
            ),
            'url'                   => array(
                'label'             => 'URL',
                'isTranslated'      => true,
                'notSearchable'     => true,
                'noList'            => true,
                'notExportable'     => true,
            ),
            'template'              => array(
                'label'             => 'Template de page',
                'noList'            => true
            ),
            'is_home'               => array(
                'type'              => 'data',
                'entity'            => 'bool',
                'fields'            => array('name'),
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
                'sort'              => 'name',
                'label'             => 'Page parent',
                'contentList'       => array('getValueEntity', 'page', 'name'),
                'norel'             => true,
                'canBeNull'         => true,
                'notRequired'       => true,
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les indexes */
            'indexes'               => array(
            ),
            /* les relations */
            'relationships'         => array(
            ),
            'orderList'             => 'hierarchy',
            'orderListDirection'    => 'ASC'
        ),
    );
