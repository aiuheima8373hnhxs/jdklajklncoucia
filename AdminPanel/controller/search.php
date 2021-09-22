<?php
return new class(){
	public function __construct(){
        core::setError();
        core::loadView('search');
    }
}
?>