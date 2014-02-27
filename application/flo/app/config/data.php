<?php
    namespace Thin;

    /* DATA */
    $fields = array(
        'name'  => array('cantBeNull' => true),
        'value' => array('cantBeNull' => true)
    );
    $conf = array(
        'checkTuple' => 'name'
    );
    data('option', $fields, $conf);

    $fields = array(
        'name'  => array('cantBeNull' => true),
        'value' => array('cantBeNull' => true)
    );
    $conf = array(
        'checkTuple' => 'name'
    );
    data('meta', $fields, $conf);

    $fields = array(
        'name'              => array(
            'cantBeNull'    => true,
            'label'         => 'Nom',
        ),
        'value'             => array(
            'cantBeNull'    => true,
            'isTranslated'  => true,
            'type'          => 'textarea',
            'label'         => 'Valeur',
        )
    );
    $conf = array(
        'checkTuple' => 'name',
            'singular'              => 'Traduction',
            'plural'                => 'Traductions',
            'orderList'             => 'name',
            'checkTuple'            => 'name',
    );
    data('translation', $fields, $conf);

    $fields = array(
        'name'          => array('cantBeNull'   => true),
        'environment'   => array('default'      => 'all', 'cantBeNull'   => true),
        'value'         => array('cantBeNull'   => true)
    );
    $conf = array(
        'checkTuple' => array('name', 'environment')
    );
    data('config', $fields, $conf);

