<?php
    namespace Thin;

    $containerConfig    = container()->getConfig();
    $db                 = new db();
    $conf               = array();

    $ajf = new database();
    $ajf->setUsername('root')->setPassword('root')->setAdapter('mysql')->setDatabase('ajf')->setHost('localhost');
    $conf['ajf'] = $ajf;
    $ab = new database();
    $ab->setUsername('root')->setPassword('root')->setAdapter('mysql')->setDatabase('albumblog')->setHost('localhost');
    $conf['albumblog'] = $ab;

    $containerConfig->setDb($conf);

    $models = array();
    $models['ajf'] = array();
    $models['ajf']['tables'] = array();
    $models['ajf']['tables']['user'] = array();
    $models['ajf']['tables']['user']['relationship'] = array();
    $models['ajf']['tables']['user']['relationship']['partner_id'] = array(
        'type'          => 'manyToOne',
        'fieldName'     => 'partner_id',
        'foreignTable'  => 'partner',
        'foreignKey'    => 'partner_id',
        'relationKey'   => 'partner',
    );


    $models['albumblog'] = array();
    $models['albumblog']['tables'] = array();
    $models['albumblog']['tables']['book'] = array();
    $models['albumblog']['tables']['book']['relationship'] = array();
    $models['albumblog']['tables']['book']['relationship']['user_id'] = array(
        'type'          => 'manyToOne',
        'fieldName'     => 'user_id',
        'foreignTable'  => 'sf_guard_user',
        'foreignKey'    => 'id',
        'relationKey'   => 'user',
    );


    $containerConfig->setModels($models);
    container()->setConfig($containerConfig);

