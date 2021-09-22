<?php
return new class(){
	public $headerData = [
		'bootstrapCSS' => '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">',
		'JQuery' => '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>',
		'BootstrapJS' => '<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>'
	];
	public function __construct(){
		$module_list = array_keys(core::$module_add);
		if(is_bool(array_search('smarty', $module_list)))
			return core::setError(1, 'smarty not exists');
		$this->generateHTMLData();
	}
	public function generateHTMLData(){
		$bootstrap = '';
		foreach($this->headerData as $data)
			$bootstrap .= $data;
		core::$module['smarty']->smarty->assign('bootstrap', $bootstrap);
	}
	public function loadBootstrapDataTable($multipleTable=false){
		$this->headerData['dataTablesCSS'] = '<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css"/>';
		$this->headerData['dataTablesJqueryJS'] = '<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>';
		$this->headerData['dataTablesBootstrapJS'] = '<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>';
		$this->headerData['dataTablesStyle'] = '<style> .dataTables_wrapper .row:last-child{ padding: 10px; } .dataTables_wrapper .row:first-child{ padding: 10px; padding-bottom: 0px; } </style>';
		if($multipleTable)
			$this->headerData['dataTablesMultipleTableJS'] = '<script> $(document).ready(function() { $(\'table.dataTable\').DataTable({ "language": { "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Polish.json" }, stateSave: true }); }); </script>';
		$this->generateHTMLData();
	}
	public function loadSelect2(){
		$this->headerData['select2CSS'] = '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />';
		$this->headerData['select2JS'] = '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>';
		$this->generateHTMLData();
	}
	public function loadCustomFileInput(){
		$this->headerData['customFileInputJS'] = '<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>';
		$this->generateHTMLData();
	}
}
?>