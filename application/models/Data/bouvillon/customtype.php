<?php
    return array(
        /* Les champs */
        'fields'                => array(
            'entity'            => array(
                'label'         => 'Entité',
            ),
            'champ'             => array(
                'label'         => 'Champs',
                'type'          => 'textarea',
                'notSearchable' => true,
                'noList'        => true
            ),
            'param'             => array(
                'label'         => 'Paramètres',
                'type'          => 'textarea',
                'notSearchable' => true,
                'noList'        => true
            ),
        ),
        /* les parametres */
        'settings'               => array(
            /* les hooks */
            'afterStore'         => function($type, $data) {
                $session = session('admin');
                $user = $session->getUser();
                $obj = new Obj;
                $obj->populate($data);
                $sql = new \Thin\Querydata('admintable');
                $res = $sql->where('name = custom_' . strtolower($obj->getEntity()))->get();
                if (!count($res)) {
                    $new = array(
                        'name' => 'custom_' . strtolower($obj->getEntity())
                    );
                    \Thin\Data::add('admintable', $new);
                    \Thin\Data::getAll('admintable');
                    $sql        = new \Thin\Querydata('admintable');
                    $res = $sql->where('name = custom_' . strtolower($obj->getEntity()))->get();
                    $admintable = $sql->first($res);

                    $actions    = \Thin\Data::getAll('adminaction');

                    foreach ($actions as $action) {
                        $action = \Thin\Data::getIt('adminaction', $action);
                        $right = array(
                            'adminuser'     => $user->getId(),
                            'admintable'    => $admintable->getId(),
                            'adminaction'   => $action->getId()
                        );
                        \Thin\Data::add('adminright', $right);
                        \Thin\Data::getAll('adminright');
                    }
                    $sql        = new \Thin\Querydata('adminright');
                    $rights = $sql->where('adminuser = ' . $user->getId())->get();

                    if (count($rights)) {
                        foreach ($rights as $right) {
                            if (!ake($right->getAdmintable()->getName(), \Thin\Data::$_rights)) {
                                \Thin\Data::$_rights[$right->getAdmintable()->getName()] = array();
                            }
                            \Thin\Data::$_rights[$right->getAdmintable()->getName()][$right->getAdminaction()->getName()] = true;
                        }
                    }
                    $session->setRights($rights);
                    $session->setDataRights(\Thin\Data::$_rights);
                }
            },
            /* les indexes */
            'indexes'            => array(
            ),
            /* les relations */
            'relationships'      => array(
            ),
            'singular'           => 'Contenu perso',
            'plural'             => 'Contenus perso',
            'checkTuple'         => 'entity',
            'orderList'          => 'entity',
            'orderListDirection' => 'ASC'
        ),
    );
