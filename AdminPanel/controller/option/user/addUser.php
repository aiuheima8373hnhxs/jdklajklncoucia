<?php
return new class(){
	public function __construct(){
		core::setError();
        if(!core::$module['account']->checkPermission('option_users') or !core::$module['account']->checkPermission('option_usersAdd'))
			header('location: 404.html');
		if(isset($_POST['addUser'])){
			if($_POST['password'] <> $_POST['password2'])
				core::$model['gui']->alert('Podane hasła się nie zgadzają', 'danger');
			elseif(strlen($_POST['password']) < 6)
				core::$model['gui']->alert('Hasło musi posiadać przynajmniej 6 znaków', 'danger');
			elseif(strlen($_POST['login']) < 4)
				core::$model['gui']->alert('Login musi posiadać minimum 4 znaki', 'danger');
			elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
				core::$model['gui']->alert('Niepoprawny adres e-mail', 'danger');
			else{
				core::$module['account']->createUser(htmlspecialchars($_POST['login']), htmlspecialchars($_POST['password']), htmlspecialchars($_POST['email']));
				if(core::$isError){
					switch(core::$error[0]){
						case 1:
							core::$model['gui']->alert('Niepoprawny adres e-mail', 'danger');
							break;
						case 2:
							core::$model['gui']->alert('Użytkownik o takim loginie już istnieje', 'danger');
							break;
						case 3:
							core::$model['gui']->alert('Błąd wykonywania polecenia', 'danger');
							core::$library->debug->print_r(core::$error[2]);
							break;
						default:
							core::$model['gui']->alert('Nieznany błąd o numerze '.core::$error[0], 'danger');
							break;
					}
				}else{
					$idUser = core::$module['account']->getUserID(htmlspecialchars($_POST['login']));
					core::$model['adminPanel/user']->changeName($idUser, $_POST['name']);
					core::$model['gui']->alert('Poprawnie dodano użytkownika', 'success');
				}
			}
		}
		core::loadView('option.user.addUser');
	}
}
?>