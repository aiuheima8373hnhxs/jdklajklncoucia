<?php
return new class(){
	public function list($groupID = null){
        core::setError();
        $perm = core::$library->database->query('SELECT * FROM AP_groupPermission'.(is_int($groupID)?(' WHERE id='.$groupID):''))->fetchAll(PDO::FETCH_ASSOC);
        foreach($perm as $id => $item)
            $perm[$id]['permission'] = json_decode($item['permission']);
        return $perm;
    }
    public function showHTMLItem(string $permissionName, bool $checked = false){
        core::setError();
        $data = $this->getPerm($permissionName);
        return '<div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="'.$permissionName.'" id="'.$permissionName.'" '.($checked?'checked':'').'>
            <label class="custom-control-label" for="'.$permissionName.'"></label>'.$data['description'].'
        </div>';
    }
    public function getPerm(string $permissionName){
        core::setError();
        $prep = core::$library->database->prepare('SELECT * FROM permissionList WHERE permName=:permName');
        $prep->bindParam(':permName', $permissionName, PDO::PARAM_STR);
        if(!$prep->execute())
            return false;
        return $prep->fetch(PDO::FETCH_ASSOC);
    }
    public function editPerm(int $permissionID, string $permissionName, array $permission){
        core::setError();
        $permission = json_encode($permission);
        $prep = core::$library->database->prepare('UPDATE AP_groupPermission SET name=:name, permission=:permission WHERE id=:permissionID');
        $prep->bindParam(':permissionID', $permissionID, PDO::PARAM_INT);
        $prep->bindParam(':name', $permissionName, PDO::PARAM_STR);
        $prep->bindParam(':permission', $permission, PDO::PARAM_STR);
        if(!$prep->execute())
            return false;
        return true;
    }
    public function addPerm(string $permissionName, array $permission){
        core::setError();
        $permission = json_encode($permission);
        $prep = core::$library->database->prepare('INSERT INTO AP_groupPermission (name, permission) VALUES (:name, :permission)');
        $prep->bindParam(':name', $permissionName, PDO::PARAM_STR);
        $prep->bindParam(':permission', $permission, PDO::PARAM_STR);
        $prep->execute();
        return true;
    }
    public function getFullPermissionArray(){
        $permArray = [];
        $prep = core::$library->database->prepare('SELECT permName FROM permissionList');
        if(!$prep->execute()) return core::setError(1);
        foreach($prep->fetchAll(PDO::FETCH_ASSOC) as $data)
            $permArray[$data['permName']] = core::$module['account']->checkPermission($data['permName']);
        return $permArray;
    }
}
?>