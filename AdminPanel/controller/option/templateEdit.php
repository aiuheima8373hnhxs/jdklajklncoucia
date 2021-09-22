<?php
return new class(){
	public function __construct(){
        core::setError();
        if(!core::$module['account']->checkPermission('option_editTemplate'))
			header('location: 404.html');
        if(isset($_POST['createFile'])){
            $file = basename($_POST['createFile']);
            file_put_contents('../'.core::$model['template']->templateDir.$file, '');
            $_POST['file'] = $file;
            core::$model['gui']->alert('Poprawnie utworzono plik', 'success');
        }
        if(isset($_POST['fileData'])){
            $file = basename($_POST['file']);
            file_put_contents('../'.core::$model['template']->templateDir.$file, $_POST['fileData']);
            core::$model['gui']->alert('Poprawnie zapisano plik', 'success');
        }
        core::loadView('option.templateEdit');
    }
}
?>