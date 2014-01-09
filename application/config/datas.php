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
        'client' => array(
            'fields' => array(
                'genre'         => array('label' => 'Civilité', 'type' => 'custom', 'custom' => 'return \\ThinService\\Admin::vocabulary(array(1 => "Monsieur", 2 => "Madame", 3 => "Mademoiselle"), "genre", "Civilité");', 'customSearch' => 'return \\ThinService\\Admin::vocabulary(array(1 => "Monsieur", 2 => "Madame", 3 => "Mademoiselle"), "genre", "Civilité", true, "##i##");', 'contentList' => array('getValueVocabulary', array(1 => "Monsieur", 2 => "Madame", 3 => "Mademoiselle"), array())),
                'name'          => array('label' => 'Nom'),
                'firstname'     => array('label' => 'Prénom'),
                'phone'         => array('label' => 'N° tél', 'noList' => true),
                'mobile'        => array('label' => 'N° Cell', 'noList' => true),
                'email'         => array('label' => 'Courriel'),
                'password'      => array('label' => 'Mot de passe', 'noList' => true, 'notSearchable' => true),
                'address'       => array('label' => 'Adresse', 'noList' => true),
                'zip'           => array('label' => 'Code postal', 'noList' => true),
                'city'          => array('label' => 'Ville', 'noList' => true),
            ),
            'settings' => array(
                'orderList'             => 'date_create',
                'orderListDirection'    => 'DESC'
            )
        ),
        'genre' => array(
            'fields' => array(
                'name'    => array('label' => 'Nom')
            ),
            'settings' => array(
                'relationships' => array(
                    'films' => array('type' => 'manyToMany', 'onDelete' => 'cascade'),
                ),
                'orderList' => 'name',
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
        'test' => array(
            'fields' => array(
                'pdf'    => array('label' => 'Brochure', 'type' => 'file')
            ),
            'settings' => array(
                'orderList' => 'pdf',
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
                        'type'      => 'unique'
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
        ),
        /* table plateforme */
        'plateforme' => array(
            'fields' => array(
                'name'    => array('label' => 'Nom')
            ),
            'settings' => array(
                'relationships' => array(
                    'films' => array('type' => 'manyToMany', 'onDelete' => 'cascade'),
                    'episodes' => array('type' => 'manyToMany', 'onDelete' => 'cascade'),
                ),
                'orderList'             => 'name',
                'orderListDirection'    => 'ASC',
                'itemsByPage'           => 25,
            )
        ),
        'saison' => array(
            'fields' => array(
                'num'    => array('label' => 'Numéro', 'type' => 'custom', 'custom' => 'return \\ThinService\\Admin::makeSaisons();', 'customSearch' => 'return \\ThinService\\Admin::makeSaisons("##i##");')
            ),
            'settings' => array(
                'orderList' => 'num',
                'orderListDirection'    => 'ASC'
            )
        ),
        'film' => array(
            'fields' => array(
                'plateforme'    => array('type' => 'data', 'entity' => 'plateforme', 'fields' => array('name'), 'sort' => 'name', 'contentList' => array('getValueEntity', 'plateforme', 'name')),
                'video_id'      => array('label' => 'ID Video', 'noList' => true, 'notSearchable' => true),
                'title'         => array('label' => 'Titre'),
                'image'         => array('label' => 'Affiche', 'type' => 'image', 'noList' => true, 'notSearchable' => true),
                'director'      => array('label' => 'Réalisateur', 'notRequired' => true),
                'genre'         => array('type' => 'data', 'entity' => 'genre', 'fields' => array('name'), 'sort' => 'name', 'contentList' => array('getValueEntity', 'genre', 'name')),
                'country'       => array('label' => 'Pays', 'notRequired' => true, 'notSearchable' => true),
                'year'          => array('label' => 'Année de sortie', 'notRequired' => true, 'notSearchable' => true),
                'duration'      => array('label' => 'Durée', 'notRequired' => true, 'notSearchable' => true),
                'synopsys'      => array('label' => 'Histoire', 'type' => 'html', 'noList' => true, 'notRequired' => true, 'notSearchable' => true),
                'actors'        => array('label' => 'Acteurs', 'type' => 'textarea', 'noList' => true, 'notRequired' => true),
            ),
            'settings' => array(
                'relationships' => array(
                    'genre' => array('type' => 'manyToOne', 'onDelete' => 'cascade'),
                    'plateforme' => array('type' => 'manyToOne', 'onDelete' => 'cascade'),
                ),
                'orderList' => 'title',
                'orderListDirection'    => 'ASC'
            )
        ),
        'episode' => array(
            'fields' => array(
                'serie'    => array('label' => 'Série', 'type' => 'data', 'entity' => 'serie', 'fields' => array('title'), 'sort' => 'title', 'contentList' => array('getValueEntity', 'plateforme', 'title')),
                'saison'         => array('type' => 'data', 'entity' => 'genre', 'fields' => array('name'), 'sort' => 'name', 'contentList' => array('getValueEntity', 'genre', 'name')),
                'plateforme'    => array('type' => 'data', 'entity' => 'plateforme', 'fields' => array('name'), 'sort' => 'name', 'contentList' => array('getValueEntity', 'plateforme', 'name')),
                'video_id'      => array('label' => 'ID Video', 'noList' => true),
                'num'           => array('label' => 'Numéro', 'type' => 'custom', 'custom' => 'return \\ThinService\\Admin::makeEpisodes();', 'customSearch' => 'return \\ThinService\\Admin::makeEpisodes("##i##");'),
                'title'         => array('label' => 'Titre', 'notRequired' => true),
                'resume'        => array('type' => 'textarea', 'label' => 'Résumé', 'notRequired' => true),
            ),
            'settings' => array(
                'orderList' => 'serie',
                'orderListDirection'    => 'ASC'
            )
        ),
    );

    return $datas;
