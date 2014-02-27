<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'price'                 => array(
                'label'             => 'Prix unitaire',
                'checkValue'        => function ($val) {
                    if (is_numeric($val)) {
                        return $val;
                    }
                    return '0';
                },
            ),
            'stock'                 => array(
                'label'             => 'Stock',
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
            'comment'               => array(
                'type'              => 'textarea',
                'label'             => 'Commentaire',
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les indexes */
            'indexes'               => array(
            ),
            /* les relations */
            'relationships'         => array(
            ),
            'singular'              => 'Produit facturable',
            'plural'                => 'Produits facturables',
            'checkTuple'            => 'name',
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC'
        ),
    );
