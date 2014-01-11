<?php
    $datas = array(
        'apikey' => array(
            'fields' => array(
                'key'      => array(),
                'resource' => array(),
            ),
            'settings' => array(
                'checkTuple'            => array('key', 'resource')
            )
        ),
        'eavrecord' => array(
            'fields' => array(
                'entity'    => array(),
                'data'      => array()
            ),
            'settings' => array()
        ),
        'asset' => array(
            'fields' => array(
                'url'    => array(),
                'name'   => array()
            ),
            'settings' => array(
                'checkTuple'            => 'url',
            )
        ),
        'youtube' => array(
            'fields' => array(
                'youtube_id'    => array('label' => 'ID Y', 'noList' => true),
                'user'          => array('noList' => true),
                'title'         => array()
            ),
            'settings' => array(
                'singular'              => 'vidéo Youtube',
                'plural'                => 'vidéos Youtube',
                'orderList'             => 'title',
                'checkTuple'            => 'youtube_id',
                'orderListDirection'    => 'ASC'
            )
        ),
        'categorie' => array(
            'fields' => array(
                'name'    => array('label' => 'Nom')
            ),
            'settings' => array(
                'relationships' => array(
                    'produits' => array('type' => 'manyToMany', 'onDelete' => 'cascade'),
                ),
                'orderList' => 'name',
                'orderListDirection'    => 'ASC'
            )
        ),
        'collection' => array(
            'fields' => array(
                'name'    => array('label' => 'Nom')
            ),
            'settings' => array(
                'relationships' => array(
                    'produits' => array('type' => 'manyToMany', 'onDelete' => 'cascade'),
                ),
                'orderList' => 'name',
                'orderListDirection'    => 'ASC'
            )
        ),
        'etat' => array(
            'fields' => array(
                'name'    => array('label' => 'Nom')
            ),
            'settings' => array(
                'relationships' => array(
                    'produits' => array('type' => 'manyToMany', 'onDelete' => 'cascade'),
                ),
                'orderList'             => 'name',
                'orderListDirection'    => 'ASC',
                'defaultValues'         => array('name' => 'Normal')
            )
        ),
        /* table produit */
        'produit'                   => array(
            /* les champs */
            'fields'                => array(
                'categorie'         => array(
                    'label'         => 'Catégorie',
                    'type'          => 'data',
                    'entity'        => 'categorie',
                    'fields'        => array('name'),
                    'sort'          => 'name',
                    'contentList'   => array('getValueEntity', 'categorie', 'name')
                ),
                'collection'        => array(
                    'type'          => 'data',
                    'canBeNull'     => true,
                    'entity'        => 'collection',
                    'fields'        => array('name'),
                    'sort'          => 'name',
                    'contentList'   => array('getValueEntity', 'collection', 'name'),
                    'notRequired'   => true
                ),
                'etat'              => array(
                    'label'         => 'état',
                    'type'          => 'data',
                    'canBeNull'     => true,
                    'entity'        => 'etat',
                    'fields'        => array('name'),
                    'sort'          => 'name',
                    'contentList'   => array('getValueEntity', 'etat', 'name'),
                    'notRequired'   => true
                ),
                'name'              => array(
                    'label'         => 'Nom'
                ),
                'cross_sell_1'      => array(
                    'label'         => 'Produit Cross Sell 1',
                    'type'          => 'data',
                    'canBeNull'     => true,
                    'entity'        => 'produit',
                    'fields'        => array('name'),
                    'sort'          => 'name',
                    'contentList'   => array('getValueEntity', 'produit', 'name'),
                    'notRequired'   => true,
                    'notExportable' => true,
                    'noList'        => true
                ),
                'cross_sell_2'      => array(
                    'label'         => 'Produit Cross Sell 2',
                    'type'          => 'data',
                    'canBeNull'     => true,
                    'entity'        => 'produit',
                    'fields'        => array('name'),
                    'sort'          => 'name',
                    'contentList'   => array('getValueEntity', 'produit', 'name'),
                    'notRequired'   => true,
                    'notExportable' => true,
                    'noList'        => true
                ),
                'description_fr'    => array(
                    'label'         => 'Description FR',
                    'type'          => 'html',
                    'canBeNull'     => true,
                    'notExportable' => true,
                    'noList'        => true
                ),
                'description_en'    => array(
                    'label'         => 'Description EN',
                    'type'          => 'html',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'image_1'           => array(
                    'label'         => 'Image N°1',
                    'type'          => 'image',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notSearchable' => true
                ),
                'image_2'           => array(
                    'label'         => 'Image N°2',
                    'type'          => 'image',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notSearchable' => true
                ),
                'image_3'           => array(
                    'label'         => 'Image N°3',
                    'type'          => 'image',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notSearchable' => true
                ),
                'price_xs'          => array(
                    'label'         => 'Prix XS',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'price_s'           => array(
                    'label'         => 'Prix S',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'price_m'           => array(
                    'label'         => 'Prix M',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'price_l'           => array(
                    'label'         => 'Prix L',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'price_Xl'          => array(
                    'label'         => 'Prix XL',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'price_housse_xs'   => array(
                    'label'         => 'Prix de la housse XS',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'price_housse_s'    => array(
                    'label'         => 'Prix de la housse S',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'price_housse_m'    => array(
                    'label'         => 'Prix de la housse M',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'price_housse_l'    => array(
                    'label'         => 'Prix de la housse L',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'price_housse_xl'   => array(
                    'label'         => 'Prix de la housse XL',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'color_code_1'      => array(
                    'label'         => 'Code couleur 1',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'color_code_2'      => array(
                    'label'         => 'Code couleur 2',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'color_code_3'      => array(
                    'label'         => 'Code couleur 3',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
                'color_code_4'      => array(
                    'label'         => 'Code couleur 4',
                    'canBeNull'     => true,
                    'noList'        => true,
                    'notExportable' => true,
                    'notRequired'   => true
                ),
            ),
            /* les parametres */
            'settings'              => array(
                /* les indexes */
                'indexes'     => array(
                    'categorie'     => array(
                        'type'      => 'multiple'
                    ),
                    'collection'    => array(
                        'type'      => 'multiple'
                    ),
                    'etat'          => array(
                        'type'      => 'multiple'
                    ),
                    'description_fr'=> array(
                        'type'      => 'fulltext'
                    ),
                ),
                /* les relations */
                'relationships'     => array(
                    'categorie'     => array(
                        'type'      => 'manyToOne',
                        'onDelete'  => 'cascade'
                    ),
                    'collection'    => array(
                        'type'      => 'manyToOne',
                        'onDelete'  => 'cascade'
                    ),
                    'etat'          => array(
                        'type'      => 'manyToOne',
                        'onDelete'  => 'cascade'
                    ),
                ),
                'versioning'         => true,
                'orderList'          => 'name',
                'orderListDirection' => 'ASC'
            )
        )
    );

    return $datas;
