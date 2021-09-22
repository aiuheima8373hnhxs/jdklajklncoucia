<?php
return new class(){
	public function __construct(){
		core::setError();
		if(!core::$module['account']->checkUser()) $this->login(); //go to login
		else $this->main(); //go to main page
	}
	private function login(){ //login
		core::setError();
		if(isset($_POST['login']) and isset($_POST['haslo'])){
			if(core::$module['account']->loginUser($_POST['login'], $_POST['haslo'])) //success
				header('location: index.html');
			else{
				switch(core::$error[0]){
					case 1:
						core::$module['smarty']->smarty->assign('error', 'Użytkownik o takim loginie nie istnieje');
						break;
					case 2:
						core::$module['smarty']->smarty->assign('error', 'Błędne hasło');
						break;
					case 3:
						core::$module['smarty']->smarty->assign('error', 'Błąd SQL');
						break;
					case 4:
						core::$module['smarty']->smarty->assign('error', 'Konto jest zablokowane');
						break;
					default:
						core::$module['smarty']->smarty->assign('error', 'Błędne dane logowania');
						break;
				}
			}
		}
		core::$module['smarty']->smarty->display('main/login.tpl'); //loading login page
	}
	private function main(){ //load main panel
		core::setError();
		$menu = core::$model['adminPanel/menu']->loadMenu();
		core::$module['smarty']->smarty->assign('menu', $menu);
		core::$module['smarty']->smarty->assign('user', core::$module['account']->userData);
		core::$module['smarty']->smarty->assign('userAvatar', core::$model['adminPanel/user']->getAvatar(-1));
		core::$module['smarty']->smarty->assign('userPermission', core::$model['permission']->getFullPermissionArray());
		//set default page
		$page = isset($_GET['page'])?$_GET['page']:'main_panel';
		foreach(core::$model['module']->moduleConfiguratorList() as $modulePath)
			include($modulePath);
		//load data
		ob_start();
		core::loadController($page);
		if(core::$error[0] > -1)
			core::loadView('404');
		$data = ob_get_contents();
		ob_end_clean();
		//show front-end
		core::$module['smarty']->smarty->assign('data', $data);
		core::$module['smarty']->smarty->display('main/main.tpl'); //loading login page
	}
}
?>