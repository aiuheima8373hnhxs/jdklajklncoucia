<div class='content pt-3'>
    <div class="container-fluid">
        <?php if(isset($_GET['searchUpdate'])){
            $uniqueID = $_GET['searchUpdate'];
            $APIData = core::$model['module']->API_getData($uniqueID, core::$model['config']->read('moduleKey_'.$uniqueID, null));
            ?>
            <div class="card card-info card-outline">
            <div class="card-header">
                Wyszukiwanie modułu o identyfikatorze <?php echo $uniqueID ?>
            </div>
            <div class="card-body">
                <?php
                    if(core::$isError)
                        core::$model['gui']->alert('Błąd pobierania danych z serwera', 'danger');
                    elseif($APIData['status'] == 'error')
                        core::$model['gui']->alert('Nie znaleziono takiego modułu w API', 'danger');
                    else{
                        $key = core::$model['config']->read('moduleKey_'.$uniqueID, null);
                        echo '<div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">UWAGA!</h4>
                            <p>Przed instalacja/aktualizacją modułu upewnij się, że pobierasz go z pewnego źródła!<br />
                            <b>Twórca FourCMS nie ponosi odpowiedzialności za pobrane pliki i konsekwencji z ich działania</b><br />
                            Ścieżka do pobranego pliku: <b>'.(is_null($APIData['data']['file'])?'':$APIData['data']['file']['filePath']).'</b></p>
                        </div>
                        Znaleziono moduł <b>'.$APIData['data']['name'].'</b><br />
                        Wersja znalezionego modułu: <b>'.$APIData['data']['version'].'</b><br />
                        '.(is_null($APIData['data']['file'])?'':'Opis wersji:<br />'.nl2br(base64_decode($APIData['data']['file']['description']))).'<br /><br />
                        <a href="module.html?installFromServer='.$APIData['data']['file']['filePath'].''.(is_null($key)?'':'?downloadKey='.$key).'" class="btn btn-primary btn-sm '.(is_null($APIData['data']['file'])?'disabled':'').'">Zainstaluj/Zaktualizuj moduł</a>';
                    }
                ?>
            </div>
        </div>
        <?php } ?>

        <div class="card card-info card-outline">
            <div class="card-header">
                Instalacja / Aktualizacja modułu z pliku
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="input-group mt-3">
                        <div class="custom-file">
                            <input name="file" type="file" class="custom-file-input">
                            <label class="custom-file-label">Wybierz moduł</label>
                        </div>
                    </div>
                    <small class="text-disabled">Maksymalny rozmiar pliku: <?php echo ini_get('upload_max_filesize') ?></small>
                </div>
                <div class="card-footer">
                    <input type="submit" value="Wgraj moduł" class="btn btn-primary" name="install" />
                    <a href="module-clearCache.html" class="btn btn-danger float-right">Wyczyść pliki tymczasowe</a>
                </div>
            </form>
        </div>

        <div class="card card-info card-outline">
            <div class="card-header">
                Moduły
            </div>
            <div class="card-body p-0">
                <table class="table">
                    <?php
                    foreach (core::$library->module->moduleList(true) as $list) {
                        if (!isset($list['config']['fourCMS'])) continue;
                        echo '<tr>
                            <td>
                                ' . (isset($list['config']['name']) ? $list['config']['name'] : $list['name']) . ' <a data-toggle="collapse" href="#collapseModule' . $list['name'] . '" role="button" aria-expanded="false" aria-controls="collapseModule' . $list['name'] . '"><i class="fas fa-info-circle"></i></a> <br />
                                <small class="text-muted">' . (isset($list['config']['description']) ? $list['config']['description'] : '') . '</small>
                                <div class="collapse" id="collapseModule' . $list['name'] . '">
                                    <span class="text-primary font-weight-bold">Dodatkowe informacje</span><br />
                                    UniqueID: <span class="text-info">' . $list['config']['uniqueID'] . '</span><br />
                                    <form method="POST" class="w-50">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" placeholder="Klucz" value="'.core::$model['config']->read('moduleKey_'.$list['config']['uniqueID'], '').'" name="key">
                                            <input type="hidden" class="form-control form-control-sm" value="'.$list['config']['uniqueID'].'" name="keyUniqueID">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-sm" name="keySave">Zapisz klucz</button>
                                            </div>
                                        </div>
                                    </form>
                                    <a href="module.html?searchUpdate='.$list['config']['uniqueID'].'" class="btn btn-xs btn-secondary">Sprawdź dostępność aktualizacji</a>
                                </div>
                            </td>
                            <td style="width: 150px">
                                Wersja: <small class="badge badge-info">' . $list['config']['version'] . '</small>
                            </td>
                        </tr>';
                    }
                    ?>
                </table>
            </div>
        </div>

        <div class="card card-info card-outline">
            <div class="card-header">
                Moduły dodatkowe
            </div>
            <div class="card-body p-0">
                <table class="table table-sm">
                    <?php
                    foreach (core::$library->module->moduleList(true) as $list) {
                        if (isset($list['config']['fourCMS'])) continue;
                        echo '<tr>
                            <td>
                                ' . (isset($list['config']['name']) ? $list['config']['name'] : $list['name']) . ' <a data-toggle="collapse" href="#collapseModule' . $list['name'] . '" role="button" aria-expanded="false" aria-controls="collapseModule' . $list['name'] . '"><i class="fas fa-info-circle"></i></a> <br />
                                <small class="text-muted">' . (isset($list['config']['description']) ? $list['config']['description'] : '') . '</small>
                                <div class="collapse" id="collapseModule' . $list['name'] . '">
                                    <span class="text-primary font-weight-bold">Dodatkowe informacje</span><br />
                                    UniqueID: <span class="text-info">' . $list['config']['uniqueID'] . '</span><br />
                                    <a href="module.html?searchUpdate='.$list['config']['uniqueID'].'" class="btn btn-xs btn-secondary">Sprawdź dostępność aktualizacji</a>
                                </div>
                            </td>
                            <td style="width: 150px">
                                Wersja: <small class="badge badge-info">' . $list['config']['version'] . '</small>
                            </td>
                        </tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    bsCustomFileInput.init()
</script>