<?php
return new class(){
	public function __construct(){
		core::setError();
		if(!core::$module['account']->checkPermission('jumbotron'))
			header('location: 404.html');
		core::loadModel('jumbotron');
		if(isset($_POST['jumbotronSave'])){
			core::$model['jumbotron']->write($_POST['header'], (isset($_POST['show'])?1:0), $_POST['text'], $_POST['url']);
			core::$model['gui']->alert('Poprawnie zapisano dane', 'success');
		}
		core::loadView('jumbotron');
	}
}
?>