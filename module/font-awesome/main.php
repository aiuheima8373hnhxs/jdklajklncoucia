<?php
return new class(){
	public function __construct(){
		$config = core::$module_add['font-awesome']['config'];
		$module_list = array_keys(core::$module_add);
		$search = array_search('smarty', $module_list);
		if($search === false)
			return core::setError(1, 'smarty not exists');
		$fontawesome = '<link rel="stylesheet" href="'.$config['path'].'script/css/all.min.css">';
		core::$module['smarty']->smarty->assign('fontawesome', $fontawesome);
	}
}
?>