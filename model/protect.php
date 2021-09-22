<?php
return new class(){
	public function protectID($id){
		core::setError();
        return (int)trim(htmlspecialchars($id));
    }
}
?>