<?php
return [
	[
		'href' => 'index.html',
		'icon' => 'fas fa-th',
		'name' => 'Panel główny',
		'htmlPage' => [
			'index.html'
		]
	],
	'post' => [
		'href' => 'post.html',
		'name' => 'Posty',
		'icon' => 'fas fa-blog',
		'permission' => 'post',
		'htmlPage' => [
			'post.html',
			'page-post.html',
			'postEdit-*.html',
			'postAdd.html'
		]
	],
	'menu' => [
		'href' => 'menu.html',
		'name' => 'Menu',
		'icon' => 'fas fa-compass',
		'permission' => 'menu',
		'htmlPage' => [
			'menu.html',
			'menuAdd.html',
			'menuDelete-*.html',
			'menuEdit-*.html',
			'menuPositionUp-*.html',
			'menuPositionDown-*.html'
		]
	],
	'jumbotron' => [
		'href' => 'jumbotron.html',
		'name' => 'Telebim',
		'icon' => 'fas fa-bullseye',
		'permission' => 'jumbotron',
		'htmlPage' => [
			'jumbotron.html',
		]
	],
	'module' => [
		'href' => '#',
		'name' => 'Moduły',
		'icon' => 'fas fa-wrench',
		'menu' => []
	],
	'option' =>[
		'href' => '#',
		'icon' => 'fas fa-cogs',
		'name' => 'Ustawienia',
		'menu' => [
			[
				'href' => 'siteTemplate.html',
				'icon' => 'fas fa-paint-brush',
				'name' => 'Szablony strony',
				'permission' => 'option_template',
				'htmlPage' => [
					'siteTemplate.html',
					'siteTemplateActive-*.html'
				]
			],
			[
				'href' => 'config.html',
				'icon' => 'fas fa-database',
				'name' => 'Zmiana konfiguracji',
				'permission' => 'option_editConfig',
				'htmlPage' => [
					'config.html',
				]
			],
			[
				'href' => 'templateEdit.html',
				'icon' => 'fas fa-edit',
				'name' => 'Edycja szablonu',
				'permission' => 'option_editTemplate',
				'htmlPage' => [
					'templateEdit.html',
				]
			],
			[
				'href' => 'userAdmin.html',
				'icon' => 'fas fa-users',
				'name' => 'Użytkownicy',
				'permission' => 'option_users',
				'htmlPage' => [
					'userAdmin.html',
					'createNewUser.html',
					'permission.html',
					'permissionEdit-*.html',
					'permissionAdd.html'
				]
			],
			[
				'href' => 'module.html',
				'icon' => 'fas fa-plug',
				'name' => 'Moduły',
				'permission' => 'option_module',
				'htmlPage' => [
					'module.html',
					'module-clearCache.html'
				]
			],
			[
				'href' => 'module-add.html',
				'icon' => 'fas fa-plug',
				'name' => 'Moduły - Instalacja',
				'permission' => 'option_moduleAdd',
				'htmlPage' => [
					'module-add.html'
				]
			]
		]
	],
	'service' => [
		'href' => '#',
		'icon' => 'fas fa-tools',
		'name' => 'Serwis',
		'permission' => 'service',
		'menu' => [
			[
				'href' => 'FrameworkLibrary.html',
				'icon' => 'fas fa-puzzle-piece',
				'name' => 'Biblioteki',
				'permission' => 'service_library',
				'htmlPage' => [
					'FrameworkLibrary.html'
				]
			],
			[
				'href' => 'FrameworkModule.html',
				'icon' => 'fas fa-plug',
				'name' => 'Moduły',
				'permission' => 'service_module',
				'htmlPage' => [
					'FrameworkModule.html',
					'FrameworkModuleInfo-*.html',
					// 'FrameworkModuleAP-*.html',
					'FrameworkModuleDebug-*.html'
				]
			],
			[
				'href' => 'logs.html',
				'icon' => 'fas fa-file',
				'name' => 'Logi',
				'permission' => 'service_logs',
				'htmlPage' => [
					'logs.html',
					'logFile-*.html',
					'logDelete-*.html'
				]
			],
			[
				'href' => 'phpInfo.html',
				'icon' => 'fab fa-php',
				'name' => 'PHP Info',
				'permission' => 'service_phpinfo',
				'htmlPage' => [
					'phpInfo.html'
				]
			]
		]
	],
	[
		'href' => 'userLogout.html',
		'icon' => 'fas fa-sign-out-alt',
		'name' => 'Wyloguj',
		'class' => 'bg-warning',
		'htmlPage' => [
			'userLogout.html'
		]
	]
];
?>