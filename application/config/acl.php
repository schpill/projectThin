<?php
    $acl = array();

    $user = new ACL;
    $user->setPassword('181dba7d095fd5540289f3cbba3b20bf');
    $user->setEmail('me@geraldplusquellec.me');
    $user->setLogin('gplusquellec');
    $user->setFirstname('Gerald');
    $user->setLastname('Plusquellec');
    $user->setRights(
        array(
            'youtube' => array(
                'list'          => true,
                'add'           => true,
                'duplicate'     => true,
                'view'          => true,
                'delete'        => true,
                'edit'          => true,
                'import'        => true,
                'export'        => true,
                'search'        => true,
                'empty_cache'   => true,
            ),
            'produit' => array(
                'list'          => true,
                'add'           => true,
                'duplicate'     => true,
                'view'          => true,
                'edit'          => true,
                'delete'        => true,
                'import'        => true,
                'export'        => true,
                'search'        => true,
                'empty_cache'   => true,
            ),
            'collection' => array(
                'list'          => true,
                'add'           => true,
                'duplicate'     => true,
                'view'          => true,
                'edit'          => true,
                'delete'        => true,
                'import'        => true,
                'export'        => true,
                'search'        => true,
                'empty_cache'   => true,
            ),
            'categorie' => array(
                'list'          => true,
                'add'           => true,
                'duplicate'     => true,
                'view'          => true,
                'edit'          => true,
                'delete'        => true,
                'import'        => true,
                'export'        => true,
                'search'        => true,
                'empty_cache'   => true,
            ),
            'etat' => array(
                'list'          => true,
                'add'           => true,
                'duplicate'     => true,
                'view'          => true,
                'edit'          => true,
                'delete'        => true,
                'import'        => true,
                'export'        => true,
                'search'        => true,
                'empty_cache'   => true,
            ),
        )
    );
    array_push($acl, $user);

    return $acl;
