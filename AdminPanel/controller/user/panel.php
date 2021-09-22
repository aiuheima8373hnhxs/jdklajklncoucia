<?php
return new class(){
    private $userID = null;
	public function __construct(){
        core::setError();
        $this->userID = isset($_GET['userID'])?(int)$_GET['userID']:(int)core::$module['account']->userData['id'];
        $userData = core::$module['account']->getData($this->userID);
        if(!$userData) header('location: 404.html');
        $this->saveUserDataFromPOSTData(); //tylko dla zalogowanego użytkownika
        $this->savePermissionFromPOSTData();
        core::$module['smarty']->smarty->assign('userData_ID', $this->userID);
        core::loadView('user.panel');
    }
    public function savePermissionFromPOSTData(){
        if(isset($_POST['save_permission'])){
            if(!core::$module['account']->checkPermission('permissionUserEdit'))
                core::$model['gui']->alert('Nie posiadasz uprawnień do zmiany tej opcji', 'danger');
            else{
                core::$module['account']->setUserPermission($userData['id'], (int)$_POST['permission']);
                core::$model['gui']->alert('Poprawnie zmieniono grupę uprawnień użytkownika', 'success');
            }
        }
    }
    public function saveUserDataFromPOSTData(){
        if((int)$this->userID === (int)core::$module['account']->userData['id']){
            if(isset($_POST['save_name'])){
                if(strlen(htmlspecialchars($_POST['name'])) < 6){
                    core::$model['gui']->alert('Nazwa użytkownika powinna zawierać <b>przynajmniej</b> 6 znaków', 'danger');
                }else{
                    core::$model['adminPanel/user']->changeName($this->userID, $_POST['name']);
                    core::$model['gui']->alert('Poprawnie zmieniono nazwę użytkownika', 'success');
                }
            }
            if(isset($_POST['save_email'])){
                if($_POST['email'] === core::$module['account']->userData['email']){
                    core::$model['gui']->alert('Taki adres e-mail jest już ustawiony', 'warning');
                }elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    core::$model['gui']->alert('Adres e-mail nie jest poprawny', 'danger');
                }else{
                    core::$model['adminPanel/user']->changeEMail($this->userID, $_POST['email']);
                    core::$model['gui']->alert('Poprawnie zmieniono adres E-Mail', 'success');
                }
            }
        }
    }
}
?>