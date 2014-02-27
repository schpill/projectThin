<?php
    return array(
        'fields' => array(
            'name'    => array('label' => 'Nom')
        ),
        'settings' => array(
            'relationships' => array(
                'slideshowmedias' => array('type' => 'manyToMany', 'onDelete' => 'cascade'),
            ),
            'singular'              => 'Diaporama',
            'plural'                => 'Diaporamas',
            'orderList'             => 'name',
            'checkTuple'            => 'name',
            'orderListDirection'    => 'ASC',
        ),
    );
