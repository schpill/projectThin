<?php
    return array(
            'fields' => array(
                'name'    => array('label' => 'Nom')
            ),
            'settings' => array(
                'relationships' => array(
                    'produits' => array('type' => 'manyToMany', 'onDelete' => 'cascade'),
                ),
                'orderList' => 'name',
                'orderListDirection'    => 'ASC',
            ),
        );
