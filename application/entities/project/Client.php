<?php
    $model = array(
        'fields' => array(
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
            'contact' => array(
                'label' => 'Contact',
                'content' => 'getContact("##self##")',
                'contentSearch' => '',
                'contentForm' => 'getContacts()',
                'sortable' => true,
                'searchable' => true,
                'required' => true,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'select'
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
                'searchable' => false,
                'required' => false,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'text'
            ),
            'address' => array(
                'label' => 'Adresse',
                'content' => '',
                'contentSearch' => '',
                'contentForm' => '',
                'sortable' => true,
                'searchable' => false,
                'required' => false,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'textarea'
            ),
            'zip' => array(
                'label' => 'Code postal',
                'content' => '',
                'contentSearch' => '',
                'contentForm' => '',
                'sortable' => true,
                'searchable' => false,
                'required' => false,
                'onList' => true,
                'onExport' => true,
                'onView' => true,
                'options' => null,
                'fieldType' => 'text'
            ),
            'city' => array(
                'label' => 'Ville',
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
        'titleList'                 => 'Liste des clients',
        'titleAdd'                  => 'Ajouter un client',
        'titleEdit'                 => 'Mettre à jour un client',
        'titleDelete'               => 'Supprimer un client',
        'titleView'                 => 'Afficher un client',
        'noResultMessage'           => 'Aucun client à afficher',
        'itemsByPage'               => 25,
        'search'                    => true,
        'order'                     => true,
        'defaultOrder'              => 'name',
        'defaultOrderDirection'     => 'ASC',
        'export'                    => array('excel', 'pdf'),
    );

    if (!function_exists('getContacts')) {
        function getContacts()
        {
            $contacts = \Thin\Project::getAll('contact');
            $return = array('' => 'Choisir');
            foreach ($contacts as $contact) {
                $contact = \Thin\Project::getObject($contact);
                $return[$contact->getId()] = $contact->getFirstname() . ' ' . $contact->getName();
            }
            return $return;
        }

        function getContact($id)
        {
            $contact = \Thin\Project::getById('contact', $id);
            return \Thin\Html\Helper::display($contact->getFirstname() . ' ' . $contact->getName());
        }
    }

    return $model;
