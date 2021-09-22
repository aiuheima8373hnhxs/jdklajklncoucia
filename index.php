<?php
ob_start();
session_start();
include('core/core.php');
$GLOBALS['FourCMS'] = 'user';

core::init(); //init core
core::loadModel('config');
core::$option['showCoreError'] = false; //ukrywanie błędów rdzenia
core::$option['saveCoreError'] = false; //zapisywanie błędów rdzenia

//load database and config
core::$library->database->connect(include('file/db_config.php'));

//load class extends
core::loadModel(['extends.module']);

//loadModule
core::loadModule('account');
core::$module['account']->sessionName = '3656fa29eb585561c83099a844c995f6';
core::$module['account']->setTablePrefix('AP');

if (core::$module['account']->checkUser()) {
    core::$module['account']->userGetData();
}

//loadModel
core::loadModel(['config', 'gui', 'link', 'module', 'protect', 'menu', 'jumbotron', 'post', 'interpreter']);

core::$module['account']->defaultPermissionGroup = (int)core::$model['config']->read('defaultUserPermissionGroup', 2);

//load front-end
$smarty = core::loadModule('smarty');
$smarty->setCaching(false);
$smarty = $smarty->smarty;
core::loadModule('bootstrap');
core::loadModel('template')->setSmartyDir();
$smarty->assign('conteinerData', '');

//account
$smarty->assign('user_isLogged', core::$module['account']->checkUser());
$smarty->assign('user', core::$module['account']->userData);

//menu - top
$smarty->assign('menu', core::$model['menu']->topMenu_read());

//jumbotron
$jumbotron = core::$model['jumbotron']->read();

if ($jumbotron <> false) {
    $smarty->assign('jumbotron', $jumbotron);
}

//smarty add config
foreach (['header_google_site_verification', 'header_keywords', 'header_description', 'title', 'header_title', 'header_charset'] as $configName) {
    $smarty->assign($configName, core::$model['config']->read($configName));
}

//loading post controller
core::loadController('main');