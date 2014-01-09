<?php
    /* SETUP!! DON'T CHANGE!! */

    $production     = array();
    $preproduction  = array();
    $staging        = array();
    $development    = array();

    $environment    = APPLICATION_ENV;

    /* PRODUCTION CONFIG */

    $smtp = new Ini;
    $smtp->setHost('in.mailjet.com');
    $smtp->setPort(587);
    $smtp->setSecure('tls');
    $smtp->setUser('tls');
    $smtp->setPassword('tls');
    $smtp->setAuth(true);

    $production['smtp']                 = $smtp;
    $production['default_module']       = 'www';
    $production['default_language']     = 'fr';
    $production['key']                  = '41ae0aaa8940980fd88d9c2906f1a538';
    $production['encoding']             = 'utf-8';

    /* PREPRODUCTION CONFIG */

    /* STAGING CONFIG */

    /* DEVELOPMENT CONFIG */



    /*
        MERGE CONFIG
    */

    if ($$environment != $production) {
        return  \Thin\Config::merge($production, $$environment);
    }
    return $$environment;
