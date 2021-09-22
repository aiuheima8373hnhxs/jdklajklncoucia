<div class='content pt-3'>
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Widgety</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-sm text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 200px">Nazwa</th>
                            <th style="width: 200px">Moduł</th>
                            <th>Opis</th>
                            <th style="width: 100px">Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach (core::$model['widget']->getUserWidget(core::$module['account']->userData['id']) as $widget) {
                            if (isset(core::$model['widget']->widgetList[$widget['uniqueIDWidget']])) {
                                $widgetData = core::$model['widget']->widgetList[$widget['uniqueIDWidget']];
                                echo '<tr>
                                    <td>' . $widgetData['name'] . '</td>
                                    <td>' . $widgetData['moduleName'] . '</td>
                                    <td>' . $widgetData['description'] . '</td>
                                    <td>
									    <a href="widget.html?posUp='.$widget['id'].'"><i class="nav-icon fas fa-arrow-up"></i></a>
									    <a href="widget.html?posDown='.$widget['id'].'"><i class="nav-icon fas fa-arrow-down"></i></a>
									    <a class="text-danger" href="widget.html?delete='.$widget['id'].'"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>';
                            } else {
                                //delete widget (old)
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Dodanie nowego widgetu do panelu</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-sm text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 200px">Nazwa</th>
                            <th>Moduł</th>
                            <th>Opis</th>
                            <th style="width: 100px">Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach (core::$model['widget']->widgetList as $widget) {
                            echo '<tr>
                                <td>' . $widget['name'] . '</td>
                                <td>' . $widget['moduleName'] . '</td>
                                <td>' . $widget['description'] . '</td>
                                <td><a href="widget.html?add=' . $widget['uniqueID'] . '"><i class="fas fa-plus"></i></a></td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>