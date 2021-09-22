<?php
return new class(){
	public function generate($array, $autoIncludeAllGet = false, array $unsetData = []){
		core::setError();
		$arrayData = '';
		if($autoIncludeAllGet == true){
			foreach($_GET as $name => $value){
				if(!isset($array[$name]))
					$array[$name] = $value;
			}
		}
		if(count($unsetData) > 0)
			foreach($unsetData as $name)
				unset($array[$name]);
		foreach($array as $name => $value){
			if (is_int($name)) {
				if(!isset($_GET[$value]))
					continue;
				$arrayData .= ($arrayData==''?'':'&').$value.'='.$_GET[$value];
			} else
				$arrayData .= ($arrayData==''?'':'&').$name.'='.$value;
		}
		return 'index.php?'.$arrayData;
	}
	public function generateAP($array=[]){
		core::setError();
		$arrayData = '';
		foreach($array as $name => $value){
			if (is_int($name)) {
				if(!isset($_GET[$value]))
					continue;
				$arrayData .= ($arrayData==''?'':'&').$value.'='.$_GET[$value];
			}else
				$arrayData .= ($arrayData==''?'':'&').$name.'='.$value;
		}
		if(isset($_GET['modul']))
			return 'FrameworkModuleAP-'.$_GET['modul'].'.html?'.$arrayData;
		else
		return 'index.html?'.$arrayData;
	}
	public function bootstrapLinkGenerator($actual='', $showList=['post', 'module', 'link'], $inputName='link'){
		core::setError();
		$explode = ($actual == '')?['', '']:(explode('-', $actual, 2));
		
		//HTML
		echo '<div class="form-row">
			<div class="form-group col-md-4">
				<select class="form-control" id="linkGenerator_main">
					<option selected>Wybierz</option>
					'.(!is_bool(array_search('post', $showList))?'<option value="post">Post</option>':'').'
					'.(!is_bool(array_search('module', $showList))?'<option value="module">Moduł</option>':'').'
					'.(!is_bool(array_search('link', $showList))?'<option value="link">Link</option>':'').'
					'.(!is_bool(array_search('controller', $showList))?'<option value="controller">Kontroler</option>':'').'
				</select>
			</div>
			<div class="form-group col-md-8">
				<select class="custom-select" id="linkGenerator_slave"><option selected>#</option></select>
				<input type="text" class="form-control" id="linkGenerator_slave2" placeholder="Link" value="#">
				<input type="text" id="link" name="'.$inputName.'" value="#"></input>
			</div>
		</div>';

		//JavaScript
		echo '<script>
		var auto1 = "'.(isset($explode[0])?$explode[0]:'Wybierz').'";
        var auto2 = "'.(isset($explode[1])?$explode[0].'-'.$explode[1]:'').'";
		var controller_list = [';
			foreach(array_diff(scandir('../'.core::$path['controller']), ['.', '..', '.htaccess']) as $item)
				echo '"'.str_replace('.php', '', $item).'", ';
		echo '];
		var post_list = [["#", "--- Pusty ---"],';
            foreach(core::$model['post']->list() as $item)
                echo '["post-'.$item['id'].'.html", "'.$item['title'].'"],';
        echo '];
        var module_list = [';
        	foreach(core::$model['module']->moduleDisplayPageList() as $item)
                echo '["module-'.$item['name'].'.html", "'.$item['title'].'"],';
        echo '];
		</script>';

		//load javascript script
		echo file_exists('script/linkGenerator.js')?'<script src="script/linkGenerator.js"></script>':'<script src="../script/linkGenerator.js"></script>';
	}
}
?>