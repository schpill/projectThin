<?php
    function rs($entity, $table)
    {
        $rss = container()->getArRelationships();
        if (is_array($rss)) {
            if (ake("$entity.$table", $rss)) {
                return $rss["$entity.$table"];
            }
        }
        return array();
    }

    $relationships = array();

    $relationships["ajf.user"] = array(
        'partner_id'    => array(
            'type'                  => 'manyToOne',
            'fieldName'             => 'partner_id',
            'foreignEntity'         => 'ajf',
            'foreignTable'          => 'partner',
            'foreignKey'            => 'partner_id',
            'foreignRelationships'  => rs('ajf', 'partner'),
            'relationKey'           => 'partner',
        )
    );

    $relationships["ajf.partner"] = array(
        'users'                     => array(
            'type'                  => 'manyToMany',
            'fieldName'             => 'users',
            'foreignEntity'         => 'ajf',
            'foreignTable'          => 'user',
            'foreignKey'            => 'user_id',
            'foreignRelationships'  => rs('ajf', 'user'),
            'relationKey'           => 'users',
        )
    );

    container()->setArRelationships($relationships);
