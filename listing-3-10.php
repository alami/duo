<?php
    require_once('Zend/Loader.php');
    Zend_Loader::registerAutoload();

    // connect to the database
//    $params = array('host'     => 'localhost',
//                    'username' => 'phpweb20',
//                    'password' => '',
//                    'dbname'   => 'phpweb20');
$config = new Zend_Config_Ini('settings.ini', 'development');
Zend_Registry::set('config', $config);
$params = array('host'     => $config->database->hostname,
    'username' => $config->database->username,
    'password' => $config->database->password,
    'dbname'   => $config->database->database);

    $db = Zend_Db::factory('pdo_mysql', $params);

    $profile = new Profile_User($db);
    $profile->setUserId(1);//должен быть  в базе
    $profile->load();

    $profile->email = 'user@example.com';
    $profile->country = 'Australia';
    $profile->save();

    if (isset($profile->country))
        echo sprintf('Your country is %s', $profile->country);
?>