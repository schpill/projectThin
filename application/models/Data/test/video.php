<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'media'                 => array(
                'label'             => 'Vidéo',
                'type'              => 'videomanager',
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
            'singular'              => 'Vidéo',
            'plural'                => 'Vidéos',
            'checkTuple'            => 'name',
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC',
        ),
    );
