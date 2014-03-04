<?php
    return array(
        /* Les champs */
        'fields'                    => array(
            'login'                 => array(
                'label'             => 'Identifiant',
            ),
            'password'              => array(
                'type'              => 'password',
                'label'             => 'Mot de passe',
                'checkValue'        => function ($val) {
                    if (!preg_match('/^[0-9a-f]{40}$/i', $val)) {
                        $val = sha1($val);
                    }
                    return $val;
                },
                'noList'            => true,
            ),
            'email'                 => array(
                'label'             => 'Courriel',
                'checkValue'        => function ($val) {
                    if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
                        throw new \Exception("You must provide a valid email.");
                    }
                    return $val;
                },
            ),
            'firstname'             => array(
                'label'             => 'Prénom',
            ),
            'name'                  => array(
                'label'             => 'Nom',
            ),
        ),
        /* les parametres */
        'settings'                  => array(
            /* les indexes */
            'indexes'               => array(
            ),
            /* les relations */
            'relationships'         => array(
            ),
            'singular'              => 'utilisateur',
            'plural'                => 'utilisateurs',
            'checkTuple'            => 'email',
            'orderList'             => 'name',
            'orderListDirection'    => 'ASC'
        ),
    );
