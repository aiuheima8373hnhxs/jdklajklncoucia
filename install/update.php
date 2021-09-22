<?php
core::$library->database->connect(include('../file/db_config.php'));
if (!core::$isError)
    echo '<div class="alert alert-primary">Wykryto sprawne połączenie z bazą danych, zostaw formularz pusty aby ich użyć w celu aktualizacji</div>';
if (isset($_POST['updateFourCMS'])) {
    echo '<h1>Aktualizowanie</h1>';
    if ($_POST['db_host'] <> '') {
        core::$library->database->connect([
            'type' => 'mysql',
            'host' => $_POST['db_host'],
            'name' => $_POST['db_name'],
            'user' => $_POST['db_username'],
            'password' => $_POST['db_password']
        ]);
    }
    core::loadModel('config');
    switch (true) {
        //0.2.3 Beta
        case core::$model['config']->read('version', '0.2.2 Beta') == '0.2.2 Beta';
            core::$model['config']->write('version', '0.2.3 Beta');
            core::$library->database->exec(file_get_contents('sql/update022bto023b.sql'));
            echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.3 Beta</div>';
        //0.2.4 Beta
        case core::$model['config']->read('version', '0.2.2 Beta') == '0.2.3 Beta';
            core::$model['config']->write('version', '0.2.4 Beta');
            core::$library->database->exec(file_get_contents('sql/update023bto024b.sql'));
            echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.4 Beta</div>';
        //0.2.5 Beta
        case core::$model['config']->read('version', '0.2.2 Beta') == '0.2.4 Beta';
            core::$model['config']->write('version', '0.2.5 Beta');
            core::$library->database->exec(file_get_contents('sql/update024bto025b.sql'));
            echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.5 Beta</div>';
        //0.2.6 Beta
        case core::$model['config']->read('version', '0.2.2 Beta') == '0.2.5 Beta';
            core::$model['config']->write('version', '0.2.6 Beta');
            core::$library->database->exec(file_get_contents('sql/update025bto026b.sql'));
            echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.6 Beta</div>';
        //0.2.6 Beta
        case core::$model['config']->read('version', '0.2.2 Beta') == '0.2.6 Beta';
            core::$model['config']->write('version', '0.2.7 Beta');
            core::$library->database->exec(file_get_contents('sql/update026bto027b.sql'));
            echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.7 Beta</div>';
        //0.2.7 Beta
        case core::$model['config']->read('version', '0.2.2 Beta') == '0.2.7 Beta';
            core::$model['config']->write('version', '0.2.8 Beta');
            echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.8 Beta</div>';
        //0.2.8 Beta
        case core::$model['config']->read('version', '0.2.2 Beta') == '0.2.8 Beta';
            core::$model['config']->write('version', '0.2.9 Beta');
            core::$library->database->exec(file_get_contents('sql/update028bto029b.sql'));
            echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.9 Beta</div>';
    }
    echo '<div class="alert alert-success">Zakończono aktualizację</div>
    <div class="alert alert-warning">Nie zapomnij usunąć folderu <b>install</b></div>';
}
?>
<form method="POST">
    <h1>Aktualizator</h1>
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
    <button type="submit" name="updateFourCMS" class="btn btn-primary btn-block">Aktualizuj</button>
</form>