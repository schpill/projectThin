<?php
    namespace Thin;

    date_default_timezone_set('America/Montreal');
    // Define path to application directory
    defined('APPLICATION_PATH') || define('APPLICATION_PATH',   realpath(dirname(__FILE__) . '/../application'));
    defined('CONFIG_PATH')      || define('CONFIG_PATH',        realpath(dirname(__FILE__) . '/../application/config'));
    defined('CACHE_PATH')       || define('CACHE_PATH',         realpath(dirname(__FILE__) . '/../storage/cache'));
    defined('LOGS_PATH')        || define('LOGS_PATH',          realpath(dirname(__FILE__) . '/../storage/logs'));
    defined('TMP_PATH')         || define('TMP_PATH',           realpath(dirname(__FILE__) . '/../storage/tmp'));
    defined('STORAGE_PATH')     || define('STORAGE_PATH',       realpath(dirname(__FILE__) . '/../storage'));
    defined('MUSIC_PATH')       || define('MUSIC_PATH',         realpath(dirname(__FILE__) . '/../storage/music'));
    defined('PHOTOS_PATH')      || define('PHOTOS_PATH',        realpath(dirname(__FILE__) . '/assets/photos'));
    defined('FILES_PATH')       || define('FILES_PATH',         realpath(dirname(__FILE__) . '/assets/files'));

    // Define path to libs directory
    defined('LIBRARIES_PATH')   || define('LIBRARIES_PATH', APPLICATION_PATH . '/../src');

    // Define application environment
    defined('APPLICATION_ENV')  || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

    define('DS', DIRECTORY_SEPARATOR);
    define('PS', PATH_SEPARATOR);

    // Ensure library/ is on include_path
    set_include_path(implode(PS, array(
        LIBRARIES_PATH,
        get_include_path()
    )));

    $debug = true;

    require_once 'Thin/Loader.php';

    require_once APPLICATION_PATH . DS . 'Bootstrap.php';
    Timer::start();

    Bootstrap::init();
