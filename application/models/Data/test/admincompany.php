<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'email'                 => array(
                'label'             => 'Courriel',
                'checkValue'        => function ($val) {
                    if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
                        throw new \Exception("You must provide a valid email.");
                    }
                    return $val;
                },
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
            'website'               => array(
                'label'             => 'Site Web',
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
            'tel'                   => array(
                'label'             => 'Téléphone',
                'canBeNull'         => true,
                'notRequired'       => true,
            ),
            'fax'                   => array(
                'label'             => 'Fax',
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
            'address'               => array(
                'type'              => 'textarea',
                'label'             => 'Adresse',
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
            'zip'                   => array(
                'label'             => 'Code postal',
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
            'city'                  => array(
                'label'             => 'Ville',
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
            'admincountry'          => array(
                'type'              => 'data',
                'entity'            => 'admincountry',
                'fields'            => array('name'),
                'sort'              => 'name',
                'label'             => 'Pays',
                'contentList'       => array('getValueEntity', 'admincountry', 'name'),
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
                'admincountry'      => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'admincountry'      => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Société',
            'plural'                => 'Sociétés',
            'checkTuple'            => array('name', 'admincountry'),
            'orderList'             => 'admincompany',
            'orderListDirection'    => 'ASC'
        ),
    );
