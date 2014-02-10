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
            'hierarchy'             => array(
                'label'             => 'Ordre',
                'default'           => 'auto',
                'checkValue'        => function ($val) {
                    if ('auto' == $val) {
                        $db = new \Thin\Querydata('adminformfield');
                        $res = $db->where('adminform = ' . $_POST['adminform'])->get();
                        return count($res) + 1;
                    }
                    return $val;
                },
            ),
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'label'                 => array(
                'label'             => 'Label',
                'isTranslated'      => true,
                'noList'            => true
            ),
            'adminformfieldtype'    => array(
                'type'              => 'data',
                'entity'            => 'adminformfieldtype',
                'fields'            => array('name'),
                'sort'              => 'name',
                'label'             => 'Type de champ',
                'contentList'       => array('getValueEntity', 'adminformfieldtype', 'name'),
            ),
            'required'              => array(
                'type'              => 'data',
                'entity'            => 'bool',
                'fields'            => array('name'),
                'default'           => getBool('true')->getId(),
                'sort'              => 'name',
                'sortOrder'         => 'DESC',
                'label'             => 'Obligatoire',
                'contentList'       => array('getValueEntity', 'bool', 'name'),
                'norel'             => true,
            ),
            'default'               => array(
                'label'             => 'Valeur par défaut',
                'type'              => 'textarea',
                'isTranslated'      => true,
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
                'adminformfieldtype'=> array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'adminform'         => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
                'adminformfieldtype'=> array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Champ de formulaire',
            'plural'                => 'Champ de formulaire',
            'checkTuple'            => 'name',
            'orderList'             => array('hierarchy','adminform'),
            'orderListDirection'    => array('ASC', 'ASC'),
        ),
    );
