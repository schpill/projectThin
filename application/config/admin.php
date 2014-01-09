<?php
    $types = array();

    $fields = array();

    /* PRODUCTS */
    array_push($types, 'products');

    $products = array(
        'fields' => array(
            'name' => array(
                'label' => 'Nom',
                'content' => '',
                'contentSearch' => '',
                'sortable' => true,
                'searchable' => true,
                'required' => true,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'text'
            ),
            'price' => array(
                'label' => 'Prix',
                'content' => '',
                'contentSearch' => '',
                'sortable' => true,
                'searchable' => true,
                'required' => true,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'text'
            ),
        ),
        'infos' => array(
                'whereList'                 => '',
                'addable'                   => true,
                'editable'                  => true,
                'deletable'                 => true,
                'viewable'                  => true,
                'duplicable'                => true,
                'pagination'                => true,
                'titleList'                 => 'Liste des produits',
                'titleAdd'                  => 'Ajouter un produit',
                'titleEdit'                 => 'Mettre à jour un produit',
                'titleDelete'               => 'Supprimer un produit',
                'titleView'                 => 'Afficher un produit',
                'noResultMessage'           => 'Aucun produit à afficher',
                'itemsByPage'               => 25,
                'search'                    => true,
                'order'                     => true,
                'defaultOrder'              => 'partner_id',
                'defaultOrderDirection'     => 'ASC',
                'export'                    => array('excel', 'pdf'),
        )
    );

    $fields['products'] = $products;



    /* Return infos */

    return array($types, $fields);
