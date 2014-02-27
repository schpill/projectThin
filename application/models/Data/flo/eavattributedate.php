<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'eavobject'             => array(
                'label'             => 'Objet',
                'type'              => 'data',
                'entity'            => 'eavobject',
                'fields'            => array('name'),
                'sort'              => 'name',
                'closureEntity'     => function ($val, $id) {
                    $object = \Thin\Data::getById('eavobject', $id);
                    $entity = \Thin\Data::getById('eaventity', $object->eaventity);
                    return $entity->getName() . ':' . $val;
                },
                'contentList'       => array('getValueEntity', 'eavobject', 'name'),
            ),
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'value'                 => array(
                'type'              => 'date',
                'label'             => 'Valeur',
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les hooks */
            /* les indexes */
            'indexes'               => array(
                'eavobject'         => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'eavobject'         => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Attribut date',
            'plural'                => 'Attributs dates',
            'checkTuple'            => array(
                'name',
                'eavobject'
            ),
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC'
        ),
    );
