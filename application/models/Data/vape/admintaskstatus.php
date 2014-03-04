<?php
    return array(
        'fields'                    => array(
            'name'                  => array(
                'label'             => 'Nom'
            ),
            'priority'              => array(
                'label'             => 'Priorité',
                'checkValue'        => function ($val) {
                    if (is_int($val)) {
                        return $val;
                    }
                    return '1';
                },
            ),
        ),
        'settings' => array(
            'relationships' => array(
                'admintasks'    => array('type' => 'manyToMany', 'onDelete' => 'cascade'),
            ),
            'singular'              => 'Statut de tâche',
            'plural'                => 'Statuts de tâche',
            'orderList'             => 'priority',
            'checkTuple'            => 'name',
            'orderListDirection'    => 'ASC',
        ),
    );
