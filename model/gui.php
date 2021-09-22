<?php
return new class(){
	public function showAlert(bool $bool, string $trueValue = 'Poprawnie wykonano operację', string $falseValue = 'Błąd wykonywania operacji', $alertOption = ['false' => 'danger', 'true' => 'success']){
        core::setError();
        if($bool)
            $this->alert($trueValue, $alertOption['true']);
        else
            $this->alert($falseValue, $alertOption['false']);
        return;
    }
    public function alert(string $value, string $alertType='secondary') : void{
		core::setError();
        echo '<div class="content-header"><div class="alert alert-'.$alertType.'" role="alert">'.$value.'</div></div>';
        return;
    }
}
?>