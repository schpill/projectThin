<?php
    return array(
        /* Les champs */
        'fields'                => array(
            'tag'               => array(
                'type'          => 'data',
                'entity'        => 'tag',
                'fields'        => array('value'),
                'sort'          => 'value',
                'contentList'   => array('getValueEntity', 'tag', 'value'),
            ),
            'page'              => array(
                'type'          => 'data',
                'entity'        => 'page',
                'fields'        => array('name'),
                'sort'          => 'name',
                'contentList'   => array('getValueEntity', 'page', 'name'),
            ),
        ),
        /* les parametres */
        'settings'              => array(
            /* les indexes */
            'indexes'           => array(
                'tag'           => array(
                    'type'      => 'multiple'
                ),
                'page'          => array(
                    'type'      => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'     => array(
                'tag'           => array(
                    'type'      => 'manyToOne',
                    'onDelete'  => 'cascade'
                ),
                'page'          => array(
                    'type'      => 'manyToOne',
                    'onDelete'  => 'cascade'
                ),
            ),
            'singular'           => 'Tag de page',
            'plural'             => 'Tags de page',
            'checkTuple'         => array('tag', 'page'),
            'orderList'          => 'page',
            'orderListDirection' => 'ASC'
        ),
    );
