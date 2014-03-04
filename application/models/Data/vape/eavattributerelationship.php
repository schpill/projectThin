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
                'label'             => 'Valeur',
                'type'              => 'data',
                'entity'            => 'eavrelationship',
                'fields'            => array('value'),
                'sort'              => 'value',
                'contentList'       => array('getValueEntity', 'eavrelationship', 'value'),
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
            'singular'              => 'Attribut relatif',
            'plural'                => 'Attributs relatifs',
            'checkTuple'            => array(
                'name',
                'eavobject'
            ),
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC'
        ),
    );
