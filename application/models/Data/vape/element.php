<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'element'             => array(
                'label'             => 'Parent',
                'type'              => 'data',
                'entity'            => 'element',
                'fields'            => array('name'),
                'sort'              => 'name',
                'contentList'       => array('getValueEntity', 'element', 'name'),
                'canBeNull'         => true,
                'notRequired'       => true,
                'notExportable'     => true,
                'noList'            => true
            ),
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'value'                 => array(
                'type'              => 'textarea',
                'label'             => 'Valeur',
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les hooks */
            /* les indexes */
            'indexes'               => array(
                'element'           => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'element'           => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Elément',
            'plural'                => 'Eléments',
            'checkTuple'            => array(
                'name',
                'element'
            ),
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC'
        ),
    );
