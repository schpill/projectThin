<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'owner'                 => array(
                'label'             => 'Donneur d\'ordre',
                'type'              => 'data',
                'entity'            => 'adminuser',
                'fields'            => array('firstname', 'name'),
                'sort'              => 'name',
                'contentList'       => array('getValueEntity', 'adminuser', 'firstname,name'),
            ),
            'adminuser'             => array(
                'label'             => 'Attribué à',
                'type'              => 'data',
                'entity'            => 'adminuser',
                'fields'            => array('firstname', 'name'),
                'sort'              => 'name',
                'contentList'       => array('getValueEntity', 'adminuser', 'firstname,name'),
            ),
            'admintasktype'         => array(
                'label'             => 'Type',
                'type'              => 'data',
                'entity'            => 'admintasktype',
                'fields'            => array('name'),
                'sort'              => 'name',
                'contentList'       => array('getValueEntity', 'admintasktype', 'name'),
            ),
            'admintaskstatus'       => array(
                'label'             => 'Statut',
                'type'              => 'data',
                'entity'            => 'admintaskstatus',
                'fields'            => array('name'),
                'sort'              => 'priority',
                'contentList'       => array('getValueEntity', 'admintaskstatus', 'name'),
            ),
            'parent'                => array(
                'label'             => 'Tâche parent',
                'type'              => 'data',
                'entity'            => 'admintask',
                'fields'            => array('name'),
                'sort'              => 'name',
                'contentList'       => array('getValueEntity', 'admintask', 'name'),
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true
            ),
            'name'                  => array(
                'label'             => 'Nom',
            ),
            'start'                 => array(
                'type'              => 'date',
                'label'             => 'Début',
            ),
            'end'                   => array(
                'type'              => 'date',
                'label'             => 'Fin',
                'canBeNull'         => true,
                'notRequired'       => true,
            ),
            'estimate'              => array(
                'label'             => 'Temps estimé (heures)',
                'canBeNull'         => true,
                'notRequired'       => true,
                'notSearchable'     => true,
                'noList'            => true
            ),
            'task'                  => array(
                'label'             => 'Tâche',
                'type'              => 'textarea',
                'canBeNull'         => true,
                'notRequired'       => true,
                'notExportable'     => true,
                'noList'            => true
            ),
            'comment'               => array(
                'type'              => 'textarea',
                'label'             => 'Commentaire',
                'canBeNull'         => true,
                'notRequired'       => true,
                'noList'            => true,
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les hooks */
            'afterStore'            => function ($type, $data) {
                $session = session('admin');
                $user = $session->getUser();
                $tos = array($user->getEmail());
                $obj = new Obj;
                $obj->populate($data);
                $sql = new \Thin\Querydata("adminuser");
                $rows = $sql->where('id = ' . $obj->getOwner())->get();
                if (count($rows)) {
                    $owner = $sql->first($rows);
                    if (!\Thin\Arrays::inArray($owner->getEmail(), $tos)) {
                        $tos[] = $owner->getEmail();
                    }
                }
                \Thin\Utils::mail(implode(', ', $tos), 'tache', 'tache', "From: tasks<tasks@gpweb.co>");
            },
            /* les indexes */
            'indexes'               => array(
                'adminuser'         => array(
                    'type'          => 'multiple'
                ),
                'admintasktype'     => array(
                    'type'          => 'multiple'
                ),
                'admintaskstatus'   => array(
                    'type'          => 'multiple'
                ),
            ),
            /* les relations */
            'relationships'         => array(
                'adminuser'         => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
                'admintasktype'     => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
                'admintaskstatus'   => array(
                    'type'          => 'manyToOne',
                    'onDelete'      => 'cascade'
                ),
            ),
            'singular'              => 'Tâche',
            'plural'                => 'Tâches',
            'checkTuple'            => array(
                'name',
                'adminuser',
                'admintasktype'
            ),
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC'
        ),
    );
