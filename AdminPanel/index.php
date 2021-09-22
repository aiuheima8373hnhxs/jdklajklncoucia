<?php
ob_start();
session_start();
include('../object/debug.php');
$GLOBALS['_debugSiteLoadMicroTime'] = microtime(true);
$GLOBALS['FourCMS'] = 'admin';
//load and init core
include('../core/core.php');
core::$option['protectModelName'] = false;
core::$option['showCoreError'] = false; //show core error
core::$option['saveCoreError'] = false; //save core error to file
core::$option['localIgnored'][] = 'model';
core::$option['localIgnored'][] = 'log';
core::init(['localPath' => true]);

//for permission
core::$library->global->createArray('permissionConfig');

//database connect
core::$library->database->connect(include('../file/db_config.php'));

//load model
core::loadModel([
    'gui', 
    'option', 
    'protect', 
    'link', 
    'config', 
    'adminPanel/user', 
    'post', 
    'module', 
    'menu', 
    'template', 
    'interpreter',
    'permission',
    'widget'
]);

//load class extends
core::loadModel(['extends.module']);

//load module
    //smarty
    core::loadModule('smarty');
    core::$module['smarty']->setTemplateDir(__DIR__.'/template/');
    core::$module['smarty']->setCaching(false);
    core::$module['smarty']->smarty->assign('title', 'FourCMS - Admin Panel');
    //load front-end module
    core::loadModule('bootstrap');
        core::$module['bootstrap']->loadBootstrapDataTable(true);
        core::$module['bootstrap']->loadCustomFileInput();
    core::loadModule('font-awesome');
    core::loadModule('adminlte');
    core::loadModule('summernote');
    //account
    core::loadModule('account');
    core::$module['account']->sessionName = '3656fa29eb585561c83099a844c995f6';
    core::$module['account']->setTablePrefix('AP');
    core::$module['account']->defaultPermissionGroup = (int)core::$model['config']->read('defaultUserPermissionGroup', 2);
    if(core::$module['account']->checkUser())
        core::$module['account']->userGetData();

core::loadModel([
    'adminPanel/menu'
]);

//smarty add config
foreach(['adminPanel_title', 'adminPanel_loginMessage'] as $configName)
    core::$module['smarty']->smarty->assign($configName, core::$model['config']->read($configName));

//load main controller
core::loadController('main');
if(boolval(core::$model['config']->read('debugBar', false)))
    core::loadView('debug');
//clean page
ob_end_flush();
?>