<?php
return new class(){
	public function __construct(){
		$config = core::$module_add['summernote']['config'];
		$module_list = array_keys(core::$module_add);
		$search = array_search('smarty', $module_list);
		if($search === false) return core::setError(1, 'smarty not exists');
		$search = array_search('bootstrap', $module_list);
		if($search === false) return core::setError(1, 'bootstrap not exists');
		$summernote = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-pl-PL.min.js"></script>';
		core::$module['smarty']->smarty->assign('summernote', $summernote);
	}
}
?>