<?php
    namespace Thin;
    $config = new config();
    $ini = new ini();
    $config->setIni($ini);
    container()->setConfig($config);
