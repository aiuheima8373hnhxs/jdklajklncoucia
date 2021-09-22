<?php
return new class(){
	public function __construct(){
		core::setError();
		if(!core::$module['account']->checkPermission('service') or !core::$module['account']->checkPermission('service_logs'))
			header('location: 404.html');
		if(isset($_GET['debug']))
			core::loadView('service.logDebug');
		elseif(isset($_GET['file']))
			core::loadView('service.logInspect');
		elseif(isset($_GET['delete'])){
			$this->_deleteFile(basename($_GET['delete'])); //function - delete file
			core::loadView('service.logList');
		}else
			core::loadView('service.logList');
	}
	private function _deleteFile($file){
		core::setError();
		$file = htmlspecialchars($file);
		$path = core::$path['log'].$file.'.log';
		if(!file_exists($path))
			core::$model['gui']->alert('Nie znaleziono takiego pliku', 'danger');
		else{
			unlink($path);
			core::$model['gui']->alert('Poprawnie usunięto plik', 'success');
		}
	}
}
?>
