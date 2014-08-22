<?php

try{

    //Read config from ini files
    $config = new \Phalcon\Config\Adapter\Ini("../app/config/application.config.ini");
    $err_config = new \Phalcon\Config\Adapter\Ini("../app/config/error.config.ini");
    $db_config = new \Phalcon\Config\Adapter\Ini("../app/config/connection.config.ini");

    //Merge into one usable config
    $config->merge($err_config);
    $config->merge($db_config);

    //Display Errors
    if($config->error->display) {
        ini_set("display_errors", 1);
        error_reporting(E_ALL);
    }

    //Register the autoloader
    $loader = new \Phalcon\Loader();

    //Register autoload directories
    $loader->registerDirs(array(
        $config->appDirs->controllers,
        $config->appDirs->models,
        $config->appDirs->plugins
    ))->register();

    //Initialze DI
    $di = new \Phalcon\DI\FactoryDefault();

    $di->setShared("config", function() use ($config){
        return $config;
    });

    //Setup the Sessions
    $di->setShared("session", function(){

        $session = new \Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;

    });

    //Setup the database connection
    $di->set("db", function() use ($config){

        $db = new \Phalcon\Db\Adapter\Pdo\Mysql( array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->dbname
        ));

        return $db;

    });

    //Setup view component
    $di->set("view", function() use ($config) {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir($config->appDirs->views);
        return $view;
    });

    //Setup the flash Service
    $di->set("flash", function(){
        $flash = new \Phalcon\Flash\Session();
        return $flash;
    });

    //Setup custom dispatcher
    $di->set("dispatcher", function() use ($di){

        $eventsmanager = $di->getShared("eventsManager");

        $permission = new Permission();

        $eventsmanager->attach("dispatch",$permission);

        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsmanager);

        return $dispatcher;

    });
    //Initialize application
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();


} catch(\Phalcon\Exception $e) {

    echo "Phalcon Exception: " . $e->getMessage();

}