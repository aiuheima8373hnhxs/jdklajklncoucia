<?php
return new class(){
	// --- TOP MENU ---
	public function topMenu_read(int $id = -1){
		core::setError();
		if($id <> -1)
			return core::$library->database->query('SELECT * FROM menu WHERE id='.(int)$id)->fetch(PDO::FETCH_ASSOC);
		foreach (core::$library->database->query('SELECT * FROM menu ORDER BY position ASC')->fetchAll(PDO::FETCH_ASSOC) as $item)
			$menu[$item['name']] = core::$model['interpreter']->generateLink($item['link']);
		if(!isset($menu))
			return;
        return $menu;
	}
	public function topMenu_readDBArray(){
		core::setError();
		return core::$library->database->query('SELECT * FROM menu ORDER BY position ASC')->fetchAll(PDO::FETCH_ASSOC);
	}
	public function topMenu_positionUp(int $id){
		core::setError();
		$item = $this->topMenu_read($id);
		if($item['position']-1 < 0)
			return false;
		core::$library->database->exec('UPDATE menu SET position = position-1 WHERE id='.$id);
		core::$library->database->exec('UPDATE menu SET position = position+1 WHERE position='.($item['position']-1).' and id<>'.$id);
		return true;
	}
	public function topMenu_positionDown(int $id){
		core::setError();
		$item = $this->topMenu_read($id);
		$count = core::$library->database->query('SELECT count(*) as count FROM menu')->fetch(PDO::FETCH_ASSOC);
		if((int)$item['position']+1 > (int)$count['count'])
			return false;
		core::$library->database->exec('UPDATE menu SET position = position+1 WHERE id='.$id);
		core::$library->database->exec('UPDATE menu SET position = position-1 WHERE position='.($item['position']+1).' and id<>'.$id);
		return true;
	}
	public function topMenu_delete(int $id){
		core::setError();
		$id = core::$model['protect']->protectID($id);
		$item = $this->topMenu_read($id);
		$exec = core::$library->database->exec('DELETE FROM menu WHERE id='.$id);
		if(!$exec)
			return false;
		core::$library->database->exec('UPDATE menu SET position = position-1 WHERE position>'.$item['position']);
		return true;
	}
	public function topMenu_write(int $id, string $name, string $link){
		core::setError();
		$id = core::$model['protect']->protectID($_GET['id']);
		$prep = core::$library->database->prepare('UPDATE menu SET `name`=:name, `link`=:link where `id`=:id');
		$prep->bindParam(':name', $name, PDO::PARAM_STR);
		$prep->bindParam(':link', $link, PDO::PARAM_STR);
		$prep->bindParam(':id', $id, PDO::PARAM_INT);
		$prep->execute();
		return true;
	}
	public function topMenu_create(string $name, string $link){
		core::setError();
		$position = (int)core::$library->database->query('SELECT count(*) as count FROM menu')->fetch(PDO::FETCH_ASSOC)['count'];
		$prep = core::$library->database->prepare('INSERT INTO menu (`name`, `link`, `position`) VALUES (:name, :link, :position)');
		$prep->bindParam(':name', $name, PDO::PARAM_STR);
		$prep->bindParam(':link', $link, PDO::PARAM_STR);
		$prep->bindParam(':position', $position, PDO::PARAM_INT);
		$prep->execute();
	}

	// --- RIGHT MENU ---
	public function rightMenu_cardRead(){
		core::setError();
		return [
			'show' => core::$model['config']->read('menuCard_show'), 
			'title' => core::$model['config']->read('menuCard_title'), 
			'text' => core::$model['config']->read('menuCard_text')
		];
	}
	public function rightMenu_read(){
		core::setError();
		$temp = [];
		foreach (core::$library->database->query('SELECT * FROM rmenu_group')->fetchAll(PDO::FETCH_ASSOC) as $item) {
			$temp[$item['name']] = [];
			foreach (core::$library->database->query('SELECT * FROM rmenu WHERE `group`='.$item['id'])->fetchAll(PDO::FETCH_ASSOC) as $item2) {
				$temp[$item['name']][$item2['name']] = $item2['link'];
			}
		}
		return $temp;
	}
}
?>