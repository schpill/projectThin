<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'name'                  => array(
                'label'             => 'Nom',
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les indexes */
            'indexes'               => array(
            ),
            /* les relations */
            'relationships'         => array(
                'adminrights' => array('type' => 'manyToMany', 'onDelete' => 'cascade'),
            ),
            'singular'              => 'table',
            'plural'                => 'tables',
            'checkTuple'            => 'name',
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC'
        ),
    );
