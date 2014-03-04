<?php
    return array(
        'fields'                    => array(
            'value'                 => array(
                'label'             => 'Valeur'
            )
        ),
        'settings'                  => array(
            'relationships'         => array(
                'tagpages'          => array(
                    'type'          => 'manyToMany',
                    'onDelete'      => 'cascade'
                ),
            ),
            'orderList'             => 'name',
            'checkTuple'            => 'name',
            'orderListDirection'    => 'ASC',
        ),
    );
