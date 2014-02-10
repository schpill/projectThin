<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'adminform'             => array(
                'type'              => 'data',
                'entity'            => 'adminform',
                'fields'            => array('name'),
                'sort'              => 'name',
                'label'             => 'Formulaire',
                'contentList'       => array('getValueEntity', 'adminform', 'name')
            ),
            'action'                => array(
                'label'             => 'Action du formulaire',
                'type'              => 'code',
                'canBeNull'         => true,
                'notRequired'       => true,
                'notExportable'     => true,
                'noList'            => true
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les indexes */
            'indexes'               => array(
                'adminform'         => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'adminform'         => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Action de formulaire',
            'plural'                => 'Action de formulaire',
            'checkTuple'            => 'name',
            'orderList'             => 'adminform',
            'orderListDirection'    => 'ASC',
        ),
    );
