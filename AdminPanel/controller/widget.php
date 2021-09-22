<?php
return new class(){
	public function __construct(){
        core::setError();
        if(isset($_GET['add'])){
            $add = core::$model['widget']->userAddWidget(core::$module['account']->userData['id'], $_GET['add']);
            core::$model['gui']->showAlert($add, 'Poprawnie dodano widget', 'Błąd dodawania widgetu');
        }
        if(isset($_GET['posDown']))
            core::$model['widget']->positionDown((int)$_GET['posDown'], (int)core::$module['account']->userData['id']);
        if(isset($_GET['posUp']))
            core::$model['widget']->positionUp((int)$_GET['posUp'], (int)core::$module['account']->userData['id']);
        if(isset($_GET['delete'])){
            $delete = core::$model['widget']->deleteUserWidget((int)$_GET['delete'], (int)core::$module['account']->userData['id']);
            core::$model['gui']->showAlert($delete, 'Poprawnie usunięto widget', 'Błąd usuwania widgetu');
        }
        core::loadView('widget');
    }
}
?>