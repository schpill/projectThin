<?php
    return array(
        /* Les champs */
        'fields'                => array(
            'name'              => array(
                'label'         => 'Nom',
            ),
            'code'              => array(
                'label'         => 'Code',
                'type'          => 'code',
                'canBeNull'     => true,
                'notRequired'   => true,
                'notExportable' => true,
                'noList'        => true
            ),
        ),
        /* les parametres */
        'settings'              => array(
            /* les indexes */
            'indexes'           => array(
            ),
            /* les relations */
            'relationships'     => array(
            ),
            'versioning'         => true,
            'checkTuple'         => 'name',
            'orderList'          => 'name',
            'orderListDirection' => 'ASC'
        ),
    );
