<?php
    namespace Thin;

    $containerConfig    = container()->getConfig();
    $db                 = new db();
    $conf               = array();

    $test = new database();
    $test->setUsername('root')->setPassword('root')->setAdapter('mysql')->setDatabase('test')->setHost('localhost');
    $conf['test'] = $test;

    $containerConfig->setDb($conf);
    container()->setConfig($containerConfig);
