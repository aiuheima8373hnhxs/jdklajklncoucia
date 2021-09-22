<?php
return new class(){
	public function read($force=false){
		core::setError();
		foreach (core::$library->database->query('SELECT * FROM jumbotron')->fetchAll(PDO::FETCH_ASSOC) as $item)
            $jumbotron[$item['name']] = $item['value'];
        if($force==true)
            return $jumbotron;
        if (boolval((int)$jumbotron['show']) == false)
            return false;
        if ($jumbotron['url'] === '')
            unset($jumbotron['url']);
        else
            $jumbotron['url'] = core::$model['interpreter']->generateLink($jumbotron['url']);
        return $jumbotron;
    }
    public function write($header, $show, $text, $url){
		core::setError();
        $prep = core::$library->database->prepare('UPDATE jumbotron SET `value`=:text where `name`="header"');
        $prep->bindParam(':text', $header);
        $prep->execute();
        $prep = core::$library->database->prepare('UPDATE jumbotron SET `value`=:text where `name`="show"');
        $prep->bindParam(':text', $show);
        $prep->execute();
        $prep = core::$library->database->prepare('UPDATE jumbotron SET `value`=:text where `name`="text"');
        $prep->bindParam(':text', $text);
        $prep->execute();
        $prep = core::$library->database->prepare('UPDATE jumbotron SET `value`=:text where `name`="url"');
        $prep->bindParam(':text', $url);
        $prep->execute();
    }
}
?>