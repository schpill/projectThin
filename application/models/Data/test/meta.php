<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'page'                  => array(
                'type'              => 'data',
                'entity'            => 'page',
                'fields'            => array('name'),
                'sort'              => 'name',
                'label'             => 'Page',
                'contentList'       => array('getValueEntity', 'page', 'name')
            ),
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'value'                 => array(
                'label'             => 'Contenu',
                'type'              => 'textarea',
                'isTranslated'      => true,
                'canBeNull'         => true,
                'notRequired'       => true,
                'notExportable'     => true,
                'noList'            => true
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les indexes */
            'indexes'               => array(
                'page'              => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'page'              => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'checkTuple'            => array('page', 'name'),
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC'
        ),
    );
