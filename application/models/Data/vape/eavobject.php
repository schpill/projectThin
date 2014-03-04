<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'eaventity'             => array(
                'label'             => 'Table',
                'type'              => 'data',
                'entity'            => 'eaventity',
                'fields'            => array('name'),
                'sort'              => 'name',
                'contentList'       => array('getValueEntity', 'eaventity', 'name'),
            ),
            'name'                  => array(
                'label'             => 'Nom',
            )
        ),
        /* les parametres */
        'settings'                  => array(
            /* les hooks */
            /* les indexes */
            'indexes'               => array(
                'eaventity'          => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'eaventity'          => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Objet',
            'plural'                => 'Objets',
            'checkTuple'            => array(
                'name',
                'eaventity'
            ),
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC'
        ),
    );
