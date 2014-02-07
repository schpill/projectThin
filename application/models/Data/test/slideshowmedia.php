<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'slideshow'             => array(
                'label'             => 'Diaporama',
                'type'              => 'data',
                'entity'            => 'slideshow',
                'fields'            => array('name'),
                'sort'              => 'name',
                'contentList'       => array('getValueEntity', 'slideshow', 'name'),
            ),
            'position'              => array(
                'label'             => 'position',
                'default'           => 'auto',
                'checkValue'        => function ($val) {
                    if ('auto' == $val) {
                        \Thin\Data::getAll('slideshowmedia');
                        $sl = $_POST['slideshow'];
                        $db = new \Thin\Querydata('slideshowmedia');
                        $rows = $db->where('slideshow = ' . $sl)->get();
                        return count($rows) + 1;
                    }
                    return $val;
                },
            ),
            'image'                 => array(
                'label'             => 'Image',
                'type'              => 'imagemanager',
                'notExportable'     => true,
                'notSearchable'     => true,
            ),
            'link'                  => array(
                'label'             => 'Lien',
                'isTranslated'      => true,
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
            'text'                  => array(
                'type'              => 'textarea',
                'label'             => 'Texte',
                'isTranslated'      => true,
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les indexes */
            'indexes'               => array(
                'slideshow'         => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'slideshow'         => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Image de diaporama',
            'plural'                => 'Gestion des diaporamas',
            'checkTuple'            => array(
                'position',
                'slideshow'
            ),
            'orderList'             => array('slideshow', 'position'),
            'orderListDirection'    => 'ASC',
        ),
    );
