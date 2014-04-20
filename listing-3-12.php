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

    // Create a new user
    $user = new DatabaseObject_User($db);
    $user->username = 'someUser';
    $user->password = 'myPassword';

    // Set their profile data
    $user->profile->email = 'user@example.com';
    $user->profile->country = 'Australia';

    // Save the user and their profile
    $user->save();

    // Load some other user and delete them
    $user2 = new DatabaseObject_User($db);
    if ($user2->load(1))//должен быть  в базе
        $user2->delete();
?>