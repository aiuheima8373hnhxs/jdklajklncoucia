<?php
return new class(){
	public function read(string $name, $default = null){
		core::setError();
		$query = core::$library->database->query('SELECT *, count(*) as count FROM config WHERE name="'.$name.'"')->fetch(PDO::FETCH_ASSOC);
		if($query['count'] == 0)
			return $default;
		return $query['value'];
	}
	public function write(string $name, $value) : bool{
		core::setError();
		$sql = 'UPDATE config SET value=:value WHERE name=:name';
		$query = core::$library->database->query('SELECT count(*) as count FROM config WHERE name="'.$name.'"')->fetch(PDO::FETCH_ASSOC);
		if($query['count'] == 0)
			$sql = 'INSERT INTO config (value, name) VALUES (:value, :name)';
		$prep = core::$library->database->prepare($sql);
		$prep->bindParam(':value', $value);
		$prep->bindParam(':name', $name);
		if(!$prep->execute())
			return false;
		return true;
	}
}
?>