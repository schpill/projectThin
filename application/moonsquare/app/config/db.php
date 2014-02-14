<?php
    namespace Thin;

    $containerConfig    = container()->getConfig();
    $db                 = new db();
    $conf               = array();

    $ajf = new database();
    $ajf->setUsername('root')->setPassword('root')->setAdapter('mysql')->setDatabase('ajf')->setHost('localhost');
    $conf['ajf'] = $ajf;

    $containerConfig->setDb($conf);
    container()->setConfig($containerConfig);
