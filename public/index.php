<?php
header("Content-Type: text/html; charset=UTF-8");

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');
defined('YII_DEBUG') or define('YII_DEBUG', true);

require dirname(__FILE__).'/../framework/yii.php';

//set time zone
date_default_timezone_set('Europe/Moscow');
//date_default_timezone_set('UTC');

$config=require dirname(__FILE__).'/protected/config/main.php';

Yii::createWebApplication($config)->run();
