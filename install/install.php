<?php
if (isset($_POST['installFourCMS'])) {
    echo '<h1>Instalacja</h1>';
    core::$library->database->connect([
        'type' => 'mysql',
        'host' => $_POST['db_host'],
        'name' => $_POST['db_name'],
        'user' => $_POST['db_username'],
        'password' => $_POST['db_password']
    ]);
    if (core::$isError)
        echo '<div class="alert alert-danger">Nie udało się połączyć z bazą danych</div>';
    else {
        core::$library->database->query(file_get_contents('sql/install.sql'));
        core::loadModule('account');
        core::$module['account']->setTablePrefix('AP');
        core::$module['account']->createUser($_POST['admin_login'], $_POST['admin_password'], 'admin@admin.pl');
        file_put_contents('../file/db_config.php', '<?php return [\'type\' => \'mysql\', \'host\' => \''.$_POST['db_host'].'\', \'name\' => \''.$_POST['db_name'].'\', \'user\' => \''.$_POST['db_username'].'\', \'password\' => \''.$_POST['db_password'].'\']; ?>');
        echo '<div class="alert alert-success">Poprawnie zainstalowaco FourCMS</div>
        <div class="alert alert-warning">Nie zapomnij usunąć folderu <b>install</b></div>';
    }
}
?>
<form method="POST">
    <h1>Instalator FourCMS</h1>
    <div class="form-group">
        <label>Host</label>
        <input type="text" name="db_host" class="form-control">
    </div>
    <div class="form-group">
        <label>Nazwa bazy danych</label>
        <input type="text" name="db_name" class="form-control">
    </div>
    <div class="form-group">
        <label>Użytkownk bazy danych</label>
        <input type="text" name="db_username" class="form-control">
    </div>
    <div class="form-group">
        <label>Hasło bazy danych</label>
        <input type="text" name="db_password" class="form-control">
    </div>
    <h1>Użytkownik</h1>
    <div class="form-group">
        <label>Login administratora</label>
        <input type="text" name="admin_login" value="admin" class="form-control">
    </div>
    <div class="form-group">
        <label>Hasło administratora</label>
        <input type="text" name="admin_password" value="admin" class="form-control">
    </div>
    <button type="submit" name="installFourCMS" class="btn btn-primary btn-block">Instaluj</button>
</form>