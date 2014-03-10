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
        'name'          => array('cantBeNull'   => true),
        'environment'   => array('default'      => 'all', 'cantBeNull'   => true),
        'value'         => array('cantBeNull'   => true)
    );
    $conf = array(
        'checkTuple' => array('name', 'environment')
    );
    data('config', $fields, $conf);

