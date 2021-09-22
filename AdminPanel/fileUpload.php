<?php
ob_start();
session_start();
include('../core/core.php');
core::init();
core::$library->database->connect(include('../file/db_config.php'));

//protect
core::loadModule('account');
core::$module['account']->setTablePrefix('AP');
if(!core::$module['account']->checkUser())
    exit;

$config = core::loadModel('config');
if(!file_exists('../'.$config->read('textarea_filePath')))
  mkdir('../'.$config->read('textarea_filePath'));
if ($_FILES['file']['name']) {
    if (!$_FILES['file']['error']) {
        $name = md5(rand(100, 200));
        $ext = explode('.', $_FILES['file']['name']);
        $filename = $name . '.' . $ext[1];
        $destination = '../images/' . $filename; //change this directory
        $location = $_FILES["file"]["tmp_name"];
        move_uploaded_file($location, $destination);
        echo '../images/' . $filename;//change this URL
    } else
        echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
}
?>