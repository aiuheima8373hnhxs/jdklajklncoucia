<?php
return new class(){
	public function __construct(){
		core::setError();
		$this->blockUser();
		$this->unblockUser();
        if(!core::$module['account']->checkPermission('option_users'))
			header('location: 404.html');
		core::loadView('option.user.list');
	}
	public function blockUser(){
		core::setError();
		if(isset($_GET['blockUser'])){
			if(!core::$module['account']->checkPermission('blockUser')){
				core::$model['gui']->alert('Nie posiadasz uprawnień do zablokowania użytkownika', 'danger');
			}elseif((int)$_GET['blockUser'] == 1)
				core::$model['gui']->alert('Nie można zablokować konta administratora', 'warning');
			else{
				$block = core::$module['account']->blockUser((int)$_GET['blockUser']);
				core::$model['gui']->showAlert($block, 'Zablokowano użytkownika', 'Nie udało się zablokować użytkownika');
			}
		}
	}
	public function unblockUser(){
		core::setError();
		if(isset($_GET['unblockUser'])){
			if(!core::$module['account']->checkPermission('blockUser')){
				core::$model['gui']->alert('Nie posiadasz uprawnień do odblokowania użytkownika', 'danger');
			}elseif((int)$_GET['unblockUser'] == 1)
				core::$model['gui']->alert('Nie można odblokować konta administratora', 'warning');
			else{
				$block = core::$module['account']->unblockUser((int)$_GET['unblockUser']);
				core::$model['gui']->showAlert($block, 'Oblokowano użytkownika', 'Nie udało się odblokować użytkownika');
			}
		}
	}
}
?>