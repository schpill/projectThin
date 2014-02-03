<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'adminclient'           => array(
                'type'              => 'data',
                'entity'            => 'adminclient',
                'fields'            => array('firstname', 'name'),
                'sort'              => 'name',
                'label'             => 'Pays',
                'contentList'       => array('getValueEntity', 'adminclient', 'firstname,name'),
            ),
            'num'                   => array(
                'label'             => 'Numéro',
                'checkValue'        => function ($val) {
                    if (is_numeric($val)) {
                        return $val;
                    }
                    return '0';
                },
            ),
            'po'                    => array(
                'label'             => 'Numéro Bon de Commande',
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
            'date_due'              => array(
                'label'             => 'Date limite de paiement',
                'type'              => 'date'
            ),
            'discount'              => array(
                'label'             => 'Rabais en %',
                'checkValue'        => function ($val) {
                    if (is_int($val) or is_float($val)) {
                        return $val;
                    }
                    return '0';
                },
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
                'adminclient'       => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'adminclient'       => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Facture',
            'plural'                => 'Factures',
            'checkTuple'            => 'num',
            'orderList'             => 'date_due',
            'orderListDirection'    => 'ASC'
        ),
    );
