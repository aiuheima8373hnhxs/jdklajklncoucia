<?php
return new class() {
    public $templateDir = null;
    public $templateName = null;
    public $defaultTemplateDir = 'defaultBlog';
    private $extendsListAdminPanel = null;
	public function __construct(){
		core::setError();
        $this->templateName = core::$model['config']->read('template_name');
        if(!file_exists('template/'.$this->templateDir))
            $this->templateName = $this->defaultTemplateDir;
        $this->templateDir = core::$library->file->repairPath('template/'.$this->templateName.'/');
    }
    public function setSmartyDir(){
        core::setError();
        core::$module['smarty']->setTemplateDir($this->templateDir);
    }
    public function templateList(){
        core::setError();
        $return = [];
        foreach(array_diff(scandir('../template/'), ['.', '..']) as $dir){
            if(is_dir('../template/'.$dir)){
                $path = core::$library->file->repairPath('../template/'.$dir.'/');
                if(file_exists($path.'template.php')){
                    $include = include($path.'template.php');
                    if(is_array($include)){
                        $return[] = [
                            'name' => isset($include['name'])?$include['name']:$dir,
                            'description' => isset($include['description'])?$include['description']:'',
                            'image' => isset($include['image'])?$path.$include['image']:'',
                            'templateName' => $dir
                        ];
                    }
                }
            }
        }
        return $return;
    }
    public function display($fileName){
        if(is_null($this->extendsListAdminPanel))
            $this->scanModuleResource();
        if(isset($this->extendsListAdminPanel[$fileName])){
            $extendsData = implode('|', $this->extendsListAdminPanel[$fileName]);
            core::$module['smarty']->smarty->addTemplateDir('../module/');
            core::$model['template']->display('extends:'.$fileName.'|'.$extendsData);
        }else
            core::$module['smarty']->smarty->display($fileName);
    }
    public function scanModuleResource(){
        $extendsListAdminPanel = [];
        foreach(core::$library->module->moduleList(true) as $moduleData){
            $modulePath = $moduleData['path'];
            $resourceTemplateDir = $modulePath.'Resources/adminPanel/template/';
            if(file_exists($resourceTemplateDir)){
                foreach($this->__getDirContents($resourceTemplateDir) as $resourcePath){
                    if(!is_dir($resourcePath)){
                        $extendsListAdminPanel[str_replace($modulePath.'Resources/adminPanel/', '', $resourcePath)][] = str_replace('../module/', '', $resourcePath);
                    }
                }
            }
        }
        $this->extendsListAdminPanel = $extendsListAdminPanel;
    }
    private function __getDirContents($dir, &$results = array()) {
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            $path = core::$library->file->repairPath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path))
                $results[] = $path;
            elseif($value != "." && $value != "..") {
                $this->__getDirContents($path, $results);
                $results[] = $path;
            }
        }
        return $results;
    }
};
?>