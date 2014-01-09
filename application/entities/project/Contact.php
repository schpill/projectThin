<?php
    $model = array(
        'fields' => array(
            'genre' => array(
                'label' => 'Civilité',
                'content' => 'crudVocabulary(##self##, array(1 => "Monsieur", 2 => "Madame", 3 => "Mademoiselle"))',
                'contentForm' => "array('' => 'Choisir', 1 => 'Monsieur', 2 => 'Madame', 3 => 'Mademoiselle')",
                'sortable' => true,
                'searchable' => false,
                'required' => true,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'select'
            ),
            'name' => array(
                'label' => 'Nom',
                'content' => '',
                'contentSearch' => '',
                'contentForm' => '',
                'sortable' => true,
                'searchable' => true,
                'required' => true,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'text'
            ),
            'firstname' => array(
                'label' => 'Prénom',
                'content' => '',
                'contentSearch' => '',
                'contentForm' => '',
                'sortable' => true,
                'searchable' => true,
                'required' => true,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'text'
            ),
            'role' => array(
                'label' => 'Fonction',
                'content' => '',
                'contentSearch' => '',
                'contentForm' => '',
                'sortable' => true,
                'searchable' => true,
                'required' => true,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'text'
            ),
            'email' => array(
                'label' => 'Courriel',
                'content' => '',
                'contentSearch' => '',
                'contentForm' => '',
                'sortable' => true,
                'searchable' => true,
                'required' => true,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'text'
            ),
            'tel' => array(
                'label' => 'Tel.',
                'content' => '',
                'contentSearch' => '',
                'contentForm' => '',
                'sortable' => true,
                'searchable' => true,
                'required' => false,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'text'
            ),
            'mobile' => array(
                'label' => 'Mobile',
                'content' => '',
                'contentSearch' => '',
                'contentForm' => '',
                'sortable' => true,
                'searchable' => true,
                'required' => false,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'text'
            ),
            'fax' => array(
                'label' => 'Fax',
                'content' => '',
                'contentSearch' => '',
                'contentForm' => '',
                'sortable' => true,
                'searchable' => true,
                'required' => false,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'text'
            ),
        ),
        'whereList'                 => '',
        'addable'                   => true,
        'editable'                  => true,
        'deletable'                 => true,
        'viewable'                  => true,
        'duplicable'                => true,
        'pagination'                => true,
        'titleList'                 => 'Liste des contacts',
        'titleAdd'                  => 'Ajouter un contact',
        'titleEdit'                 => 'Mettre à jour un contact',
        'titleDelete'               => 'Supprimer un contact',
        'titleView'                 => 'Afficher un contact',
        'noResultMessage'           => 'Aucun contact à afficher',
        'itemsByPage'               => 25,
        'search'                    => true,
        'order'                     => true,
        'defaultOrder'              => 'name',
        'defaultOrderDirection'     => 'ASC',
        'export'                    => array('excel', 'pdf'),
    );

    /* fonctions */
    if (!function_exists('crudVocabulary')) {
        function crudVocabulary($index, $tab)
        {
            if (isset($tab[$index])) {
                return $tab[$index];
            }

            return '';
        }

        function selectMinMax($min = 1, $max = 10)
        {
            $return = array('' => 'Choisir');
            for ($i = $min ; $i <= $max ; $i++) {
                $return[$i] = $i;
            }
            return $return;
        }

        function goUrl($url)
        {
            return '<button type="button" class="btn btn-success" name="validNo" onclick="window.open(\''.$url.'\', \'goCrud\')"><span class="icon-share-alt"></span></button>';
        }

        function selectBool()
        {
            $return = array('' => 'Choisir', 1 => 'Oui', 0 => 'Non');
        }

        function dateCrud($datetime)
        {
            return \Thin\Html\Date::timestamp($datetime);
        }
    }

    return $model;
