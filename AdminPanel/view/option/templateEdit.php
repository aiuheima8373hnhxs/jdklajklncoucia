<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edytor szablonów</h1>
            </div>
        </div>
    </div>
</div>

<div class='content'>
    <div class="container-fluid">
        <div class='card'>
            <div class='card-header'>
                Inforamcje
            </div>
            <div class="card-body">
                Nazwa szablonu: <?php echo core::$model['template']->templateName ?><br />
                Folder szablonu: <?php echo core::$model['template']->templateDir ?><br />
                Rozmiar szablonu: <?php echo core::$library->memory->formatBytes(core::$library->file->dirSize('../' . core::$model['template']->templateDir)) ?><br />
                Plików: <?php echo core::$library->file->fileCount('../' . core::$model['template']->templateDir) ?>
            </div>
        </div>

        <div class='card'>
            <div class='card-header'>
                Wybór pliku do edycji
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label>Wybór pliku</label>
                        <select class="custom-select mb-3" name="file">
                            <?php
                            foreach (array_diff(scandir('../' . core::$model['template']->templateDir), ['.', '..']) as $item) {
                                echo '<option value="' . $item . '">' . $item . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button class="btn btn-primary">Wybierz plik do edycji</button>
                </form>
            </div>
        </div>

        <div class='card'>
            <div class='card-header'>
                Utworzenie pliku
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label>Nazwa pliku</label>
                        <input type="text" class="form-control" name="createFile" placeholder="Nazwa pliku" value="">
                    </div>
                    <button class="btn btn-primary">Utwórz plik</button>
                </form>
            </div>
        </div>

        <?php if (isset($_POST['file'])) { $file = basename($_POST['file']); ?>
            <div class='card'>
                <div class='card-header'>
                    Edycja pliku <b><?php echo $file ?></b>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input style="display: none;" type="text" class="form-control" name="file" value="<?php echo $file ?>">
                        <div class="form-group">
                            <textarea class="form-control" rows="25" name="fileData"><?php echo file_get_contents('../' . core::$model['template']->templateDir . $file); ?></textarea>
                        </div>
                        <button class="btn btn-primary">Zapis pliku</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>