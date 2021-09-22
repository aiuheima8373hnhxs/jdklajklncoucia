<?php
return new class(){
	public function __construct(){
		core::setError();
		if(!core::$module['account']->checkPermission('option_template'))
			header('location: 404.html');
		if(isset($_GET['template'])){
			core::$model['config']->write('template_name', $_GET['template']);
			core::$model['gui']->alert('Poprawnie zmieniono szablon', 'success');
		}
		core::loadView('option.template');
	}
}
?>