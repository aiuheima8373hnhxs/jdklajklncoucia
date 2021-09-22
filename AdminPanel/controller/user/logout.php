<?php
return new class(){
	public function __construct(){
        core::setError();
        core::$module['account']->logoutUser();
        header('location: index.php');
    }
}
?>