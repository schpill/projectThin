<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'media'                 => array(
                'label'             => 'Image',
                'type'              => 'imagemanager',
                'notExportable'     => true,
                'notSearchable'     => true,
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
            'singular'              => 'Image',
            'plural'                => 'Images',
            'checkTuple'            => 'name',
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC',
        ),
    );
