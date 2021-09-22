<?php
if ($_GET['editID'] <> 'addNew') {
    $edit = false;
    $group = core::$model['permission']->list((int)htmlspecialchars($_GET['editID']))[0];
    $permission = $group['permission'];
    $GLOBALS['permission'] = $permission;
} else {
    $edit = true;
    $group['name'] = '';
    $permission = [];
}
function permissionPregReplace($matches){
    return core::$model['permission']->showHTMLItem($matches[1], !is_bool(array_search($matches[1], $GLOBALS['permission'])));
}
?>
<div class='content pt-3'>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <?php
                    if ($edit)
                        echo 'Dodanie grupy uprawnień';
                    else
                        echo 'Edytowanie grupy uprawnień';
                    ?></div>
            </div>
            <form method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nazwa</label>
                        <input type="text" class="form-control" name="permissionName" placeholder="Nazwa grupy uprawnień" value="<?php echo $group['name'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Uprawnienia</label>
                        <?php echo core::$model['permission']->showHTMLItem('all_granted', !is_bool(array_search('all_granted', $permission))) ?>
                        <!-- Posty -->
                        <b>Posty</b>
                        <?php echo core::$model['permission']->showHTMLItem('post', !is_bool(array_search('post', $permission))) ?>
                        <!-- Telebim -->
                        <b>Telebim</b>
                        <?php echo core::$model['permission']->showHTMLItem('jumbotron', !is_bool(array_search('jumbotron', $permission))) ?>
                        <!-- Menu -->
                        <b>Menu</b>
                        <?php echo core::$model['permission']->showHTMLItem('menu', !is_bool(array_search('menu', $permission))) ?>
                        <b>Użytkownik</b>
                        <?php echo core::$model['permission']->showHTMLItem('otherUser', !is_bool(array_search('otherUser', $permission))) ?>
                        <!-- Uprawnienia -->
                        <b>Uprawnienia</b>
                        <?php echo core::$model['permission']->showHTMLItem('permissionUserEdit', !is_bool(array_search('permissionUserEdit', $permission))) ?>
                        <!-- Ustawienia -->
                        <b>Ustawienia</b>
                        <?php echo core::$model['permission']->showHTMLItem('option_template', !is_bool(array_search('option_template', $permission))) ?>
                        <?php echo core::$model['permission']->showHTMLItem('option_editTemplate', !is_bool(array_search('option_editTemplate', $permission))) ?>
                        <?php echo core::$model['permission']->showHTMLItem('option_editConfig', !is_bool(array_search('option_editConfig', $permission))) ?>
                        <?php echo core::$model['permission']->showHTMLItem('option_users', !is_bool(array_search('option_users', $permission))) ?>
                        <div class="ml-3">
                            <?php echo core::$model['permission']->showHTMLItem('blockUser', !is_bool(array_search('blockUser', $permission))) ?>
                            <?php echo core::$model['permission']->showHTMLItem('option_usersAdd', !is_bool(array_search('option_usersAdd', $permission))) ?>
                            <?php echo core::$model['permission']->showHTMLItem('option_permissionEdit', !is_bool(array_search('option_permissionEdit', $permission))) ?>
                        </div>
                        <?php echo core::$model['permission']->showHTMLItem('option_module', !is_bool(array_search('option_module', $permission))) ?>
                        <!-- Serwis -->
                        <b>Serwis</b>
                        <?php echo core::$model['permission']->showHTMLItem('service', !is_bool(array_search('service', $permission))) ?>
                        <div class="ml-3">
                            <?php echo core::$model['permission']->showHTMLItem('service_library', !is_bool(array_search('service_library', $permission))) ?>
                            <?php echo core::$model['permission']->showHTMLItem('service_module', !is_bool(array_search('service_module', $permission))) ?>
                            <?php echo core::$model['permission']->showHTMLItem('service_logs', !is_bool(array_search('service_logs', $permission))) ?>
                            <?php echo core::$model['permission']->showHTMLItem('service_phpinfo', !is_bool(array_search('service_phpinfo', $permission))) ?>
                        </div>
                        <b>Moduły</b>
                        <?php echo core::$model['permission']->showHTMLItem('module', !is_bool(array_search('module', $permission))) ?>
                        <?php echo core::$model['permission']->showHTMLItem('moduleInstall', !is_bool(array_search('moduleInstall', $permission))) ?>
                        <?php echo core::$model['permission']->showHTMLItem('moduleAdd', !is_bool(array_search('moduleAdd', $permission))) ?>

                        <?php
                        foreach(core::$library->global->read('permissionConfig') as $permData){
                            echo preg_replace_callback('~\[permission\](.*?)\[/permission\]~s', 'permissionPregReplace', $permData);
                            // echo $permData;
                        }
                        ?>
                    </div>
                </div>
                <div class="card-footer">
                    <?php
                    if ($edit)
                        echo '<button type="submit" class="btn btn-primary" name="addPermission">Dodaj</button>';
                    else
                        echo '<button type="submit" class="btn btn-primary" name="savePermission">Zapisz</button>';
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>