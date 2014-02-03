<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'adminuser'             => array(
                'type'              => 'data',
                'entity'            => 'adminuser',
                'fields'            => array('firstname', 'name'),
                'sort'              => 'name',
                'label'             => 'Utilisateur',
                'contentList'       => array('getValueEntity', 'adminuser', 'firstname,name'),
            ),
            'admintable'            => array(
                'type'              => 'data',
                'entity'            => 'admintable',
                'fields'            => array('name'),
                'sort'              => 'name',
                'label'             => 'Table',
                'contentList'       => array('getValueEntity', 'admintable', 'name'),
            ),
            'adminaction'           => array(
                'type'              => 'data',
                'entity'            => 'adminaction',
                'fields'            => array('name'),
                'sort'              => 'name',
                'label'             => 'Droit',
                'contentList'       => array('getValueEntity', 'adminaction', 'name'),
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les indexes */
            'indexes'               => array(
                'adminaction'       => array(
                    'type'          => 'multiple'
                ),
                'admintable'        => array(
                    'type'          => 'multiple'
                ),
                'adminuser'         => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'adminaction'       => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
                'admintable'        => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
                'adminuser'         => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'habilitation',
            'plural'                => 'habilitations',
            'checkTuple'            => array('admintable', 'adminuser', 'adminaction'),
            'orderList'             => 'admintable',
            'orderListDirection'    => 'ASC'
        ),
    );
