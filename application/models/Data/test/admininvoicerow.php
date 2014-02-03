<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'admininvoice'           => array(
                'type'              => 'data',
                'entity'            => 'admininvoice',
                'fields'            => 'num',
                'sort'              => 'num',
                'label'             => 'Facture',
                'contentList'       => array('getValueEntity', 'admininvoice', 'num'),
            ),
            'adminproduct'           => array(
                'type'              => 'data',
                'entity'            => 'adminproduct',
                'fields'            => array('num', 'price'),
                'sort'              => 'name',
                'label'             => 'Produit facturé',
                'contentList'       => array('getValueEntity', 'adminproduct', 'num,price'),
            ),
            'qty'                   => array(
                'label'             => 'Quantité',
                'checkValue'        => function ($val) {
                    if (is_int($val) or is_float($val)) {
                        return $val;
                    }
                    return '0';
                },
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
                'admininvoice'      => array(
                    'type'          => 'multiple'
                ),
                'adminproduct'      => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'admininvoice'      => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
                'adminproduct'      => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Ligne de facture',
            'plural'                => 'Lignes de facture',
            'checkTuple'            => 'admininvoice',
            'orderList'             => 'admininvoice',
            'orderListDirection'    => 'ASC'
        ),
    );
