<script src="../script/krumo/krumo.min.js"></script>
<?php
$krumoDefaultExpand = boolval(core::$model['config']->read('debugBarDefaultExpandData', false));
?>
<div class="modal" tabindex="-1" role="dialog" id="debugBarModal">
    <div class="modal-dialog modal-lg modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Debugger</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs mb-1" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" data-toggle="tab" href="#debugBar_debug">Debug</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#debugBar_core">Rdzeń</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#debugBar_smarty">Smarty</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#debugBar_variables">Zmienne</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#debugBar_includeFile">Wczytane pliki</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#debugBar_modelList">Modele</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#debugBar_moduleList">Moduły</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#debugBar_info">Informacje</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <!-- debug -->
                    <div class="tab-pane fade show active" id="debugBar_debug" role="tabpanel">
                        <b>Debugowanie ze strony</b><br />
                        <ul class="list-unstyled">
                            <?php echo debug::$formatString ?>
                        </ul>
                    </div>
                    <!-- core -->
                    <div class="tab-pane fade show" id="debugBar_core" role="tabpanel">
                        <?php $coreDebugClass = new ReflectionClass('core');
                        $krumoDefaultExpand ? krumo($coreDebugClass->getStaticProperties(), KRUMO_EXPAND_ALL) : krumo($coreDebugClass->getStaticProperties()) ?>
                    </div>
                    <!-- variable -->
                    <div class="tab-pane fade show" id="debugBar_variables" role="tabpanel">
                        <b>Globalne</b>
                        <?php krumo($GLOBALS) ?>
                    </div>
                    <!-- Template Smarty -->
                    <div class="tab-pane fade show table-responsive" id="debugBar_smarty" role="tabpanel">
                        <span class="badge badge-secondary">core::$module['smarty']->smarty->tpl_vars</span><br />
                        <b>Zmienne</b>
                        <?php $krumoDefaultExpand ? krumo(core::$module['smarty']->smarty->tpl_vars, KRUMO_EXPAND_ALL) : krumo(core::$module['smarty']->smarty->tpl_vars); ?>
                    </div>
                    <!-- include file -->
                    <div class="tab-pane fade show table-responsive" id="debugBar_includeFile" role="tabpanel">
                        <?php
                        $krumoDefaultExpand ? krumo::includes(KRUMO_EXPAND_ALL) : krumo::includes();
                        ?>
                    </div>
                    <!-- model list -->
                    <div class="tab-pane fade show" id="debugBar_modelList" role="tabpanel">
                        <nav>
                            <div class="nav nav-tabs mb-1" id="nav-tab" role="tablist">
                                <?php
                                foreach (core::$model as $name => $value) {
                                    echo '<a class="nav-item nav-link" data-toggle="tab" href="#debugBar_model_' . $name . '">' . $name . '</a>';
                                }
                                ?>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <?php
                                foreach (core::$model as $name => $value) {
                                    echo '<div class="tab-pane fade show" id="debugBar_model_' . $name . '" role="tabpanel">';
                                    $krumoDefaultExpand ? krumo(core::$model[$name], KRUMO_EXPAND_ALL) : krumo(core::$model[$name]);
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </nav>
                    </div>
                    <!-- module list -->
                    <div class="tab-pane fade show" id="debugBar_moduleList" role="tabpanel">
                        <nav>
                            <div class="nav nav-tabs mb-1" id="nav-tab" role="tablist">
                                <?php
                                foreach (core::$module as $name => $value) {
                                    echo '<a class="nav-item nav-link" data-toggle="tab" href="#debugBar_module_' . $name . '">' . $name . '</a>';
                                }
                                ?>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <?php
                                foreach (core::$module as $name => $value) {
                                    echo '<div class="tab-pane fade show" id="debugBar_module_' . $name . '" role="tabpanel">
                                    <b>Plik konfiguracyjny</b>';
                                    $krumoDefaultExpand ? krumo(core::$module_add[$name]['config'], KRUMO_EXPAND_ALL) : krumo(core::$module_add[$name]['config']);
                                    echo '<b>Klasa</b>';
                                    $krumoDefaultExpand ? krumo(core::$module[$name], KRUMO_EXPAND_ALL) : krumo(core::$module[$name]);
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </nav>
                    </div>
                    <!-- info -->
                    <div class="tab-pane fade show table-responsive" id="debugBar_info" role="tabpanel">
                        <b>Czas ładowania strony:</b> <?php echo isset($GLOBALS['_debugSiteLoadMicroTime']) ? round(microtime(true) - $GLOBALS['_debugSiteLoadMicroTime'], 3) . 's' : 'Brak danych' ?><br />
                        <b>Załadowany kontroler:</b> <?php echo isset($_GET['page'])?str_replace('.', ' -> ', $_GET['page']):'Brrak informacji' ?> <span class="badge badge-info float-right">Dane pobrane ze zmiennej $_GET['page']</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        $(document).keypress(function(event) {
            if (event.which == 96) {
                $('#debugBarModal').modal('show');
            }
        });
    });
</script>