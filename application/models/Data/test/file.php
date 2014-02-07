<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'name'                  => array(
                'label'             => 'Nom'
            ),
            'media'                 => array(
                'label'             => 'Fichier',
                'type'              => 'filemanager',
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
            'singular'              => 'Fichier',
            'plural'                => 'Fichiers',
            'checkTuple'            => 'name',
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC',
        ),
    );
