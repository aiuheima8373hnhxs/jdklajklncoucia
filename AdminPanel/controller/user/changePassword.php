<?php
return new class(){
	public function __construct(){
        core::setError();
        if(isset($_POST['haslo']))
			core::$model['adminPanel/user']->changePassword();
        core::loadView('user.changePassword');
    }
}
?>