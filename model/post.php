<?php
return new class(){
	public function read(int $id){
		core::setError();
        $post = core::$library->database->query('SELECT * FROM post WHERE id='.$id)->fetch(PDO::FETCH_ASSOC);
        if((is_null($post['id']) or boolval($post['hidden']) == true) and $GLOBALS['FourCMS'] <> 'admin')
            return false;
        $post['text'] = $this->__imageDirProtect($post['text']);
        $post['userName'] = core::$module['account']->getData((int)$post['user'])['name'];
        return $post;
    }
    public function list(){
		core::setError();
        $where = '';
        if($GLOBALS['FourCMS'] == 'user')
            $where .= '`hidden`=0';
        if($where <> '')
            $where = 'WHERE '.$where;
        $post = core::$library->database->query('SELECT * FROM post ORDER BY date DESC')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($post as $key=>$item) {
            $post[$key]['text'] = strip_tags($item['text']);
            $post[$key]['userName'] = core::$module['account']->getData((int)$item['user'])['name'];
            if($post[$key]['url'] == "auto")
                $post[$key]['url'] = 'post-'.$post[$key]['id'].'.html';
        }
        return $post;
    }
    public function create(string $title, string $text, int $user, $url='auto', string $type='post', $hidden=false, $showMetadata=false){
		core::setError();
        $prep = core::$library->database->prepare('INSERT INTO post (`text`, `title`, `user`, `url`, `type`, `hidden`, `showMetaData`) VALUES (:text, :title, :user, :url, :type, :hidden, :showMetaData)');
        $prep->bindValue(':text', $text, PDO::PARAM_STR);
        $prep->bindValue(':title', $title, PDO::PARAM_STR);
        $prep->bindValue(':user', $user, PDO::PARAM_INT);
        $prep->bindValue(':url', $url, PDO::PARAM_STR);
        $prep->bindValue(':type', $type, PDO::PARAM_STR);
        $prep->bindValue(':hidden', $hidden, PDO::PARAM_INT);
        $prep->bindValue(':showMetaData', $showMetadata, PDO::PARAM_INT);
        if(!$prep->execute())
            return false;
        return core::$library->database->conn->lastInsertId();
    }
    public function update(int $id, string $title, string $text, int $user, $url='auto', string $type='post', $hidden=false, $showMetadata = false){
		core::setError();
        $prep = core::$library->database->prepare('UPDATE post SET `text`=:text, `title`=:title, '.($user<>-1?'`user`=:user,':'').' `url`=:url, `type`=:type, `hidden`=:hidden, `showMetaData`=:showMetaData WHERE `id`='.$id);
		$prep->bindValue(':text', $text, PDO::PARAM_STR);
        $prep->bindValue(':title', $title, PDO::PARAM_STR);
        if($user<>-1) $prep->bindValue(':user', $user, PDO::PARAM_INT);
        $prep->bindValue(':url', $url, PDO::PARAM_STR);
        $prep->bindValue(':type', $type, PDO::PARAM_STR);
        $prep->bindValue(':hidden', $hidden, PDO::PARAM_INT);
        $prep->bindValue(':showMetaData', $showMetadata, PDO::PARAM_INT);
        if(!$prep->execute())
            return false;
        return true;
    }
    public function delete(int $id){
		core::setError();
        $prep = core::$library->database->prepare('DELETE FROM post WHERE `id`=:id');
        $prep->bindValue(':id', $id, PDO::PARAM_INT);
        if(!$prep->execute())
            return core::setError(1);
        if($prep->rowCount() == 0)
            return core::setError(2);
        return true;
    }
    private function __imageDirProtect($text){
		core::setError();
        $text = str_replace('src="../', '<img src="', $text);
        $text = str_replace("src='../", "<img src='", $text);
        return $text;
    }
}
?>