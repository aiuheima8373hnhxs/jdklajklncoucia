<?php
class moduleExtends{
    private $moduleExtendsConfig = [
        'moduleConfig' => null,
        'pathList' => [
            'controller' => null,
            'model' => null,
            'view' => null
        ]
    ];
    public $model = [];
    public function __construct(){
        core::setError();
        if(!isset($GLOBALS['module_config']))
            trigger_error('ERROR: moduleExtends not found $GLOBALS[\'module_config\'] variable', E_USER_ERROR);
        $this->moduleExtendsConfig['moduleConfig'] = $GLOBALS['module_config'];
        $this->moduleExtendsConfig['pathList'] = [
            'controller' => $GLOBALS['module_config']['path'].'controller'.DIRECTORY_SEPARATOR,
            'model' => $GLOBALS['module_config']['path'].'model'.DIRECTORY_SEPARATOR,
            'view' => $GLOBALS['module_config']['path'].'view'.DIRECTORY_SEPARATOR
        ];
    }
    public function loadView(string $name){
        core::setError();
		$path = $this->moduleExtendsConfig['pathList']['view'].str_replace('.', DIRECTORY_SEPARATOR, $name).'.php';
		if(!file_exists($path))
			return core::setError(1, 'file not exists', 'file not exists in path: ('.$path.')');
		return include($path);
    }
    public function loadController(string $name){
        core::setError();
		$path = $this->moduleExtendsConfig['pathList']['controller'].str_replace('.', DIRECTORY_SEPARATOR, $name).'.php';
		if(!file_exists($path))
			return core::setError(1, 'file not exists', 'file not exists in path: ('.$path.')');
		$includeClass = include($path);
		return $includeClass;
    }
    public function loadModel(string $name){
        core::setError();
		if(in_array($name, array_keys($this->model)))
			return $this->$model[$name];
		$path = $this->moduleExtendsConfig['pathList']['model'].str_replace('.', DIRECTORY_SEPARATOR, $name).'.php';
		if(!file_exists($path))
			return core::setError(1, 'file not exists', 'file not exists in path: ('.$path.')');
		$includeClass = include($path);
		$this->model[$name] = $includeClass;
		return $includeClass;
    }
    public function loadModelsFromArray(array $models){
        core::setError();
        foreach($models as $model)
            $this->loadModel($model);
    }
}
?>