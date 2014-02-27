<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'admincompany'          => array(
                'type'              => 'data',
                'entity'            => 'admincompany',
                'fields'            => array('name'),
                'sort'              => 'name',
                'label'             => 'Société',
                'contentList'       => array('getValueEntity', 'admincompany', 'name'),
            ),
            'firstname'             => array(
                'label'             => 'Prénom',
            ),
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
            ),
            'tel_work'              => array(
                'label'             => 'Téléphone Bureau',
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
            'tel_home'              => array(
                'label'             => 'Téléphone Domicile',
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
            'tel_cellular'          => array(
                'label'             => 'Téléphone Mobile',
                'canBeNull'         => true,
                'notRequired'       => true,
            ),
            'fax'                   => array(
                'label'             => 'Fax',
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
                'admincompany'      => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'admincompany'      => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Client',
            'plural'                => 'Clients',
            'checkTuple'            => array('email', 'admincompany'),
            'orderList'             => 'admincompany',
            'orderListDirection'    => 'ASC'
        ),
    );
