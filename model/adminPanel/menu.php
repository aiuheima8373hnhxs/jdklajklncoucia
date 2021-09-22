<?php
return new class(){
	private $load = null;
	private $data = '';
	private $activeUrl = null;
	private $activeUrlFull = null;
	private $lastGroupID = '';
	private $moduleExPosition = 2;
	public function __construct(){
		core::setError();
		$this->setActiveURL(basename(isset($_SERVER['REDIRECT_URL'])?$_SERVER['REDIRECT_URL']:$_SERVER['SCRIPT_NAME']));
        $this->load = include('../file/adminPanel_menu.php');
		$this->loadModuleMenu();
		$this->hiddenElement();
		$this->loadModuleMenuEx();
	}
	public function loadMenu(){
		core::setError();
		$this->loadTree($this->load); //load tree (html)
		return $this->data;
    }
	private function hiddenElement(){
		if(boolval(core::$model['config']->read('APmenu_jumbotron')) == false)
			unset($this->load['jumbotron']);
		if(boolval(core::$model['config']->read('APmenu_serwis')) == false)
			unset($this->load['service']);
		if(boolval(core::$model['config']->read('APmenu_menu')) == false)
			unset($this->load['menu']);
	}
	private function loadModuleMenuEx(){
		$list = core::$library->module->moduleList(true);
		foreach($list as $item){
			$cfg = $item['config'];
			if(!isset($cfg['fourCMS']['menuItem']))
				continue;
			$config = $cfg['fourCMS']['menuItem'];
			$insert = [
				'href' => 'FrameworkModuleAP-'.$item['name'].'.html',
				'name' => $config['name'],
				'icon' => isset($config['icon'])?$config['icon']:'fas fa-circle',
				'htmlPage' => isset($config['htmlPage'])?$config['htmlPage']:[],
			];
			if(isset($config['permission']))
				$insert['permission'] = $config['permission'];
			array_splice($this->load, $this->moduleExPosition, 0, [$insert]);
		}
	}
    private function loadTree($array){
		core::setError();
		foreach($array as $item){
			if(isset($item['permission'])){
				if(!core::$module['account']->checkPermission($item['permission']))
					continue;
			}
			$actUrl = false;
			if(isset($item['htmlPage']))
				if(!is_bool(array_search($this->activeUrl, $item['htmlPage'])) or !is_bool(array_search($this->activeUrlFull, $item['htmlPage'])))
					$actUrl = true;
			if($actUrl)
				$item['class'] = 'active';
			$this->lastGroupID = core::$library->string->generateString(15, [true, true, false, false]);
			$this->data .= '<li id="'.(isset($item['menu'])?$this->lastGroupID:'').'" class="nav-item '.(isset($item['menu'])?'has-treeview':'').'">
				<a href="'.$item['href'].'" class="nav-link '.(isset($item['class'])?$item['class']:'').'">
					<i class="nav-icon '.(isset($item['icon'])?$item['icon']:'fas fa-circle').'"></i>
					<p>'.$item['name'].'</p>
					'.(isset($item['menu'])?'<i class="right fas fa-angle-left"></i>':'').'
				</a>';
				if(isset($item['menu'])){
					$this->data .= '<ul class="nav nav-treeview">';
					$this->loadTree($item['menu']);
					$this->data .= '</ul>';
				}
			$this->data .= '</li>';
		}
	}
	private function loadModuleMenu(){
		core::setError();
		$search = core::$library->array->searchByKey($this->load, 'name', 'Moduły');
		$list = core::$library->module->moduleList(true);
		foreach($list as $item)
			if(isset($item['config']['adminPanel']))
				if(isset($item['config']['adminPanel']['menu'])){
					$apMenu = $item['config']['adminPanel']['menu'];
					$array = [
						'href' => 'FrameworkModuleAP-'.$item['name'].'.html',
						'icon' => 'fas '.$apMenu['icon'],
						'name' => $apMenu['name'],
						'htmlPage' => isset($apMenu['htmlPage'])?$apMenu['htmlPage']:[],
					];
					if(isset($apMenu['permission']))
						$array['permission'] = $apMenu['permission'];
					array_push($this->load[$search]['menu'], $array);
				}
		if(count($this->load[$search]['menu']) == 0)
			unset($this->load[$search]);
	}
	public function setActiveURL($url){
		$urlFull = $url;
		if(!is_bool(strpos($url, '-'))){
			$between = core::$library->string->between($url, '-', '.html');
			if(!is_null($between)){
				$urlFull = $url;
				$url = str_replace($between, '*', $url);
			}
		}
		$this->activeUrl = $url;
		$this->activeUrlFull = $urlFull;
	}
}
?>