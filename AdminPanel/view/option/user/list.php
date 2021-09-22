<?php
$permissionDataList = [];
foreach (core::$model['permission']->list() as $item) {
    $permissionData = '';
    foreach ($item['permission'] as $name) {
        $perm = core::$model['permission']->getPerm($name);
        $permissionData .= ($permissionData<>''?', ':'').$perm['name'];
    }
    $permissionDataList[$item['id']] = $permissionData;
}
?>
<div class='content pt-3'>
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Użytkownicy</h3>
                <div class="card-tools">
                    <!-- edycja uprawnień użytkownika -->
                    <a href="permission.html" type="button" class="btn btn-tool" data-toggle="tooltip" title="Uprawnienia użytkowników"><i class="far fa-object-group"></i></a>
                    <!-- dodanie użytkownika -->
                    <a href="createNewUser.html" type="button" class="btn btn-tool <?php echo !core::$module['account']->checkPermission('option_usersAdd') ? 'disabled' : '' ?>" data-toggle="tooltip" title="Dodanie nowego użytkownika"><i class="fas fa-user-plus"></i></a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-sm text-nowrap dataTable">
                    <thead>
                        <tr>
                            <th style="width: 1px">#</th>
                            <th style="width: 200px">Login</th>
                            <th style="width: 200px">Nazwa</th>
                            <th style="width: 250px">E-Mail</th>
                            <th style="width: 150px">Uprawnienia</th>
                            <th>Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach (core::$module['account']->getUserList() as $item) {
                            echo '<tr>
                                <td>' . $item['id'] . '</td>
                                <td>'.($item['blocked']?'<s>':'').'<a href="user-'.$item['id'].'.html">' . $item['login'] . '</a>'.($item['blocked']?'</s> <i class="fas fa-ban text-danger" data-toggle="tooltip" data-original-title="Konto zablokowane"></i>':'').'</td>
                                <td>' . $item['name'] . '</td>
                                <td>' . $item['email'] . '</td>
                                <td style="cursor: help;" data-toggle="tooltip" title="'.$permissionDataList[$item['permission']].'">'.core::$module['account']->getPermissionName($item['permission']).'</td>
                                <td>'.(!$item['blocked']?'<a href="userAdmin.html?blockUser='.$item['id'].'" class="btn btn-warning btn-xs '.(($item['id']=="1" or !core::$module['account']->checkPermission('blockUser') or (int)core::$module['account']->userData['id'] == (int)$item['id'])?'disabled':'').'">Zablokuj</a>':'<a href="userAdmin.html?unblockUser='.$item['id'].'" class="btn btn-info btn-xs  '.(!core::$module['account']->checkPermission('blockUser')?'disabled':'').'">Odblokuj</a>').'</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>