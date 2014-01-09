<?php
    $acl = array();

    $user = new ACL;
    $user->setPassword('181dba7d095fd5540289f3cbba3b20bf');
    $user->setEmail('me@geraldplusquellec.me');
    $user->setLogin('gplusquellec');
    $user->setFirstname('Gerald');
    $user->setLastname('Plusquellec');
    $user->setRole('admin');
    $user->setPages(
        array(
            'youtube',/*
            'apikeys',
            'tests',
            'etats',
            'collections',
            'categories',*/
            'produit',/*
            'clients',
            'films',
            'series',
            'genres',
            'saisons',
            'episodes',
            'plateformes'*/
        )
    );
    array_push($acl, $user);

    $user = new ACL;
    $user->setPassword('3119fa3edbf614f8e047dfc82001177a');
    $user->setEmail('orochon@pilouf.ca');
    $user->setLogin('orochon');
    $user->setFirstname('Olivier');
    $user->setLastname('Rochon');
    $user->setRole('admin');
    $user->setPages(array('etat', 'collection', 'categorie', 'produit', 'client'));
    array_push($acl, $user);

    return $acl;
