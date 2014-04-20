<?php
    require_once('Zend/Loader.php');
//require_once 'Zend/Loader/Autoloader.php';
    Zend_Loader::registerAutoload();
//$autoloader = Zend_Loader_Autoloader::getInstance();
//$autoloader->setFallbackAutoloader(true);

    // load the application configuration
    $config = new Zend_Config_Ini('settings.ini', 'development');
    Zend_Registry::set('config', $config);


    // create the application logger
    $logger = new Zend_Log(new Zend_Log_Writer_Stream($config->logging->file));
    Zend_Registry::set('logger', $logger);


    // connect to the database
    $params = array('host'     => $config->database->hostname,
                    'username' => $config->database->username,
                    'password' => $config->database->password,
                    'dbname'   => $config->database->database);

    $db = Zend_Db::factory($config->database->type, $params);
    Zend_Registry::set('db', $db);

//---------------------------listings;//<------START
    $user2 = new DatabaseObject_User($db);
    if ($user2->load(3))
        $user2->delete();
//---------------------------

    // setup application authentication
    $auth = Zend_Auth::getInstance();
    $auth->setStorage(new Zend_Auth_Storage_Session());

//$logger->debug('index-3');
//-------------------------------------//<------END
    // handle the user request
    $controller = Zend_Controller_Front::getInstance();
    $controller->setControllerDirectory($config->paths->base .
                                        '/include/Controllers');
    $controller->registerPlugin(new CustomControllerAclManager($auth));//<-----LINE

    // setup the view renderer
    $vr = new Zend_Controller_Action_Helper_ViewRenderer();
    $vr->setView(new Templater());
    $vr->setViewSuffix('tpl');
    Zend_Controller_Action_HelperBroker::addHelper($vr);

    $controller->dispatch();
?>