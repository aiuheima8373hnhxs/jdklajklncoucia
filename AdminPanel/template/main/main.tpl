<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{$title}</title>
    {$bootstrap}
    {$fontawesome}
    {$adminlte}
    {$summernote}
    <script src="script/menu.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-dark navbar-gray-dark">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="index.html"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.html" class="nav-link">Strona główna</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../index.php" class="nav-link">CMS</a>
                </li>
            </ul>
            <form action="search.html" method="GET" class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input name="searchMenu" class="form-control form-control-navbar" type="search"
                        placeholder="Wyszukiwarka" aria-label="Wyszukiwarka">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index.html" class="brand-link">
                <img src="../module/adminlte/script/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{$adminPanel_title}</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{$userAvatar}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="user.html" class="d-block" style="">{$user['name']}</a>
                        </div>
                    </div>
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview"
                        role="menu" data-accordion="false">
                        {block name=menu}
                            {if isset($menu)}
                                {$menu}
                            {/if}
                        {/block}
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            {block name=data}
                {if isset($data)}
                    {$data}
                {/if}
            {/block}
        </div>
        <footer class="main-footer">
            {block name=footer}
                <div class="float-right d-none d-sm-inline">
                    Panel administracyjny dla <a href='https://krzysztofzylka.pl/'>FourCMS</a>
                </div>
                <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
                reserved.
            {/block}
        </footer>
    </div>
</body>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

</html>