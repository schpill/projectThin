<?php
    return array(
        'fields'                    => array(
            'name'                  => array(
                'label'             => 'Nom'
            ),
        ),
        'settings'                  => array(
            'relationships'         => array(
                'eavobjects'        => array(
                    'type'          => 'manyToMany',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Table',
            'plural'                => 'Tables',
            'orderList'             => 'name',
            'checkTuple'            => 'name',
            'orderListDirection'    => 'ASC',
        ),
    );
