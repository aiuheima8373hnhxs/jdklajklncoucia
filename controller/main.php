<?php
return new class() {
    public function __construct() {
        if (isset($_GET['post'])) { //isset post
            if ($_GET['post'] == 'list') {
                unset($_GET['post']);
            }

            core::loadController('post');
        } elseif (isset($_GET['module'])) {
            core::$model['interpreter']->loadScript('module/' . htmlspecialchars($_GET['module']));
        } else {
            core::$model['interpreter']->loadScript(core::$model['config']->read('mainPage'));
        }
    }
}
?>