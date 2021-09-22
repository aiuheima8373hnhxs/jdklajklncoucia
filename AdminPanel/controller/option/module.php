<?php
return new class(){
	public function __construct(){
		core::setError();
		if(!core::$module['account']->checkPermission('option_module'))
			header('location: 404.html');
		$this->installFromPOSTData();
		$this->clearInstallerCacheFromGETData();
		$this->downloadAndinstallModuleFromGETData();
		$this->saveModuleKeyFromGETData();
		if(isset($_GET['page2']) and $_GET['page2'] == 'moduleAdd'){
			core::loadView('option.moduleAdd');
		}else
			core::loadView('option.module');
	}
	public function saveModuleKeyFromGETData(){
		if(isset($_POST['keySave'])){
			core::$model['config']->write('moduleKey_'.$_POST['keyUniqueID'], $_POST['key']);
			core::$model['gui']->alert('Poprawnie zapisano klucz dla modułu', 'success');
		}
	}
	public function installFromPOSTData(){
		if(isset($_POST['install'])){
			$this->installModule();
		}
	}
	public function downloadAndinstallModuleFromGETData(){
		if(isset($_GET['installFromServer'])){
			$urlToFile = $_GET['installFromServer'];
			$tempFilePath = core::$path['temp'].'downloadModuleFile.zip';
			file_put_contents($tempFilePath, fopen($urlToFile, 'r'));
			$this->installModule($tempFilePath);
			if(file_exists($tempFilePath))
				unlink($tempFilePath);
		}
	}
	public function installModule($file=null){
		$file = $file??$_FILES['file']['tmp_name'];
		if(core::$module['account']->checkPermission('moduleInstall')){
			if(isset($file)){
				core::$model['module']->installModule($file);
				if(core::$isError){
					switch((int)core::$error[0]){
						case 1:
							core::$model['gui']->alert('Nie znaleziono pliku ZIP', 'danger');
							break;
						case 2:
							core::$model['gui']->alert('Folder temp istnieje (jeżeli nic nie jest instalowane albo nastąpił błąd instalacji/aktualizacji użyj przycisku "Wyczyść pliki tymczasowe")', 'danger');
							break;
						case 3:
							core::$model['gui']->alert('Brak rozszerzenia do obsługi plików ZIP', 'danger');
							break;
						case 4:
							core::$model['gui']->alert('Błąd otwarcia pliku ZIP', 'danger');
							break;
						case 5:
							core::$model['gui']->alert('Nie znaleziono pliku konfiguracyjnego (config.php)', 'danger');
							break;
						case 6:
							core::$model['gui']->alert('Plik konfiguracyjny nie posiada danych moduleDirectory', 'danger');
							break;
						case 7:
							core::$model['gui']->alert('Plik ZIP nie zawiera folderu z modułem (moduleDirectory)', 'danger');
							break;
						case 8:
							core::$model['gui']->alert('Brak pliku wymaganego poczas aktualizacji (update.php)', 'danger');
							break;
						case 9:
							core::$model['gui']->alert('Brak pliku wymaganego poczas instalacji (install.php)', 'danger');
							break;
						case 10:
							core::$model['gui']->alert('Plik update.php zwrócił błąd', 'danger');
							break;
						case 11:
							core::$model['gui']->alert('Plik install.php zwrócił błąd', 'danger');
							break;
						default:
							core::$model['gui']->alert('Wystąpił nieznany błąd', 'danger');
							break;
					}
				}else{
					unlink($file);
					core::$model['gui']->alert('Poprawnie zainstalowano/zaktualizowano moduł', 'success');
				}
			}else
				core::$model['gui']->alert('Błąd formularza', 'danger');
		}else
			core::$model['gui']->alert('Nie posiadasz uprawnień do wgrywania modułów z plików', 'danger');
	}
	public function clearInstallerCacheFromGETData(){
		if(isset($_GET['clearInstallerCache']) and $_GET['clearInstallerCache'] == "true"){
			core::$library->file->rmdir(core::$path['temp'].'installModule'.DIRECTORY_SEPARATOR);
			core::$model['gui']->alert('Usunięto pliki cache', 'success');
		}
	}
}
?>