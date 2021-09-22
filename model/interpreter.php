<?php
return new class(){
	public function loadScript(string $data){
		core::setError();
        $data = explode('/', $data, 2);
        if(count($data) == 1)
            $data = explode('-', $data[0], 2);
        switch($data[0]){
            case 'controller':
                core::loadController($data[1]);
                break;
            case 'post':
                $_GET['post'] = $data[1];
                core::loadController('post');
                break;
            case 'module':
                $exp = explode('/', $data[1], 2);
                if(count($exp) == 1){
                    $exp = explode('-', $data[1], 2);
                    $exp[1] = str_replace('.html', '', $exp[1]);
                }
                ob_start();
                core::$model['module']->moduleDisplay($exp[0], $exp[1]);
                $data = ob_get_contents();
                ob_end_clean();
                core::$module['smarty']->smarty->assign('conteinerData', $data);
                core::$module['smarty']->smarty->display('empty.tpl');
                break;
            case 'link':
                header('location: '.$data[1]);
                break;
        }
    }
    public function generateLink(string $data){
		core::setError();
        $dataOrginal = $data;
        $data = explode('/', $data, 2);
        switch($data[0]){
            case 'post':
                return 'post-'.$data[1].'.html';
                break;
            case 'module':
                return 'module-'.str_replace('/', '-', $data[1]).'.html';
                break;
            default:
                return $dataOrginal;
                break;
        }
    }
    public function showPrettyText($data){
		core::setError();
        $dataOrginal = $data;
        $data = explode('/', $data, 2);
        if(count($data) == 1) $data = explode('-', $data[0], 2);
        switch($data[0]){
            case 'post':
                $data[1] = str_replace('.html', '', $data[1]);
                $post = core::$model['post']->read((int)$data[1]);
                if($post == false){
                    return '-- Nie znaleziono postu --';
                    break;
                }
                $data[1] = $post['title'];
                return $data[0].' -> '.$data[1];
                break;
            case 'module':
                $exp = explode('-', $data[1], 2);
                $post = core::$path['module'];
                $configPath = core::$library->file->repairPath($post.$exp[0].'/config.php');
                if (!file_exists($configPath)) {
                    $data[1] = 'Nie można znaleść pliku konfiguracyjnego modułu';
                    break;
                }
                $config = include($configPath);
                $data[1] = $exp[0].' -> '.$config['fourCMS']['displayPage'][str_replace('.html', '', $exp[1])]['name'];
                return $data[0].' -> '.$data[1];
                break;
        }
        return $dataOrginal;
    }
}
?>