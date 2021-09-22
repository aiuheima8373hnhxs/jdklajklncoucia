<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
return new class(){
	public $config;
	private $mail = null;
	private $configTable = null;
	public function __construct(){
		$this->config = $GLOBALS['module_config'];
		$this->_loadPHPMailerFile();
	}
	public function configurate($config = []){
		$this->mail = new PHPMailer(true);
		try {
			$this->configTable = $config;
			if(isset($config['debug']) and $config['debug'] == true)
				$this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
			$this->mail->isSMTP();
			$this->mail->Host = $config['host'];
			$this->mail->SMTPAuth = true;
			$this->mail->Username = $config['username'];
			$this->mail->Password = $config['password'];
			$this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$this->mail->Port = $config['port'];
			$this->mail->CharSet = isset($config['CharSet'])?$config['CharSet']:'UTF-8';
			return true;
		} catch (Exception $e) {
			return core::setError(1, 'set configurate error', $e);
		}
	}
	public function sendMail($config = []){
		try {
			$this->mail->setFrom($config['from'], $config['fromTitle']);
			if(isset($config['replayTo']))
				$this->mail->addReplyTo($config['replayTo'], $config['replayToTitle']);
			$this->mail->addAddress($config['sendTo'], $config['sendToName']);
			$this->mail->Subject = $config['subject'];
			$this->mail->Body = $config['body'];
			$this->mail->send();
			return true;
		} catch (Exception $e) {
			return core::setError(1, 'send error', $e);
		}
	}
	private function _loadPHPMailerFile(){
		require $this->config['path'].'script/Exception.php';
		require $this->config['path'].'script/PHPMailer.php';
		require $this->config['path'].'script/SMTP.php';
	}
}
?>