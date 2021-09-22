<div class='content pt-3'>
    <div class="container-fluid">
        <div class="card">
            <div class='card-header'>
                <div class="card-title">Kategorie uprawnień</div>
                <div class="card-tools">
                    <a href="permissionAdd.html" class="btn btn-tool <?php echo !core::$module['account']->checkPermission('option_permissionEdit') ? 'disabled' : '' ?>" data-toggle="tooltip" data-placement="left" title="Dodaj kategorię"><i class="fas fa-plus"></i></a>
                </div>
            </div>
            <div class='card-body p-0'>
                <table class="table table-sm text-nowrap dataTable table-responsive">
                    <thead>
                        <tr>
                            <th style="width: 250px">Nazwa</th>
                            <th>Uprawnienia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach (core::$model['permission']->list() as $item) {
                            $permission = '';
                            foreach ($item['permission'] as $name) {
                                $perm = core::$model['permission']->getPerm($name);
                                $permission .= '<span class="badge bg-info" data-toggle="tooltip" title="' . $perm['description'] . '">' . $perm['name'] . '</span> ';
                            }
                            echo '<tr>
                            <td>' . $item['name'] . ' ' . (core::$module['account']->checkPermission('option_permissionEdit') ? ('<a href="permissionEdit-'.$item['id'].'.html"><i class="fas fa-edit"></i></a>') : '') . '</td>
                            <td>' . (!is_bool(array_search('all_granted', $item['permission'])) ? '<span class="badge bg-warning">Pełne uprawnienia</span>' : $permission) . '</td>
                        </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>