<?php
    return array(
        /* Les champs */
        'fields'                => array(
            'collection'        => array(
                'type'          => 'data',
                'entity'        => 'collection',
                'fields'        => array('name'),
                'sort'          => 'name',
                'contentList'   => array('getValueEntity', 'collection', 'name'),
            ),
            'name'              => array(
                'label'         => 'Nom',
            ),
            'value'             => array(
                'label'         => 'Contenu',
                'type'          => 'textarea',
                'isTranslated'  => true,
                'canBeNull'     => true,
                'notRequired'   => true,
                'notExportable' => true,
                'noList'        => true
            ),
        ),
        /* les parametres */
        'settings'              => array(
            /* les indexes */
            'indexes'           => array(
                'collection'    => array(
                    'type'      => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'     => array(
                'collection'    => array(
                    'type'      => 'manyToOne',
                    'onDelete'  => 'cascade'
                ),
            ),
            'singular'           => 'Objet',
            'plural'             => 'Objets',
            'checkTuple'         => array(
                'name', 'collection'
            ),
            'orderList'          => 'name',
            'orderListDirection' => 'ASC'
        ),
    );
