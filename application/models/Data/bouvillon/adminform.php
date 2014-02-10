<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'page'                  => array(
                'type'              => 'data',
                'entity'            => 'page',
                'fields'            => array('name'),
                'sort'              => 'name',
                'label'             => 'Page de retour',
                'contentList'       => array('getValueEntity', 'page', 'name'),
            ),
            'button'                => array(
                'label'             => 'Libellé du bouton submit',
                'default'           => 'Envoyer',
                'isTranslated'      => true,
                'notExportable'     => true,
                'noList'            => true
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les indexes */
            'indexes'               => array(
                'page'              => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'page'              => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Formulaire',
            'plural'                => 'Formulaires',
            'checkTuple'            => array('name', 'page'),
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC'
        ),
    );
