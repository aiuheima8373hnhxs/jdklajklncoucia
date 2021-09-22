<?php
include('../core/core.php');
core::init([
    'autoCreatePath' => false,
    'showCoreError' => false,
    'saveCoreError' => false
]);
core::$library->database->connError = false;
?>
<!doctype html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>FourCMS - Instalacja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-3">
        <?php
        if(!file_exists('../file/db_config.php') or (isset($_GET['type']) and $_GET['type'] == 'install'))
            include('install.php');
        else
            include('update.php');
        ?>
    </div>
</body>

</html>