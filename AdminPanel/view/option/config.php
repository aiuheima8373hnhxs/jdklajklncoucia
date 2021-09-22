<?php
$permissionData = [];
foreach (core::$module['account']->getPermissionList() as $item)
    $permissionData[$item['id']] = $item['name'];
core::$model['option']->generateOption([
    [
        'type' => 'container-fluid',
        'data' => [
            [
                'type' => 'card',
                'header' => [
                    'title' => 'Konfiguracja treści oraz nagłówków'
                ],
                'data' => [
                    [
                        'type' => 'card-configTable',
                        'data' => [
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'title',
                                'description' => 'Tytuł strony',
                                'name' => 'Tytuł strony'
                            ],
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'header_title',
                                'description' => 'Tytuł strony (w pasku adresu)',
                                'name' => 'Treść nagłówka'
                            ],
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'header_google_site_verification',
                                'description' => 'Weryfikowanie własności witryny GOOGLE (site verification)',
                                'name' => 'Weryfikacja GOOGLE'
                            ],
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'header_keywords',
                                'description' => 'Słowa kluczowe dla wirtyny',
                                'name' => 'Słowa kluczowe'
                            ],
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'header_description',
                                'description' => 'Opis witryny (w nagłówku)',
                                'name' => 'Opis witryny'
                            ],
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'header_charset',
                                'description' => 'Kodowanie strony',
                                'name' => 'Kodowanie strony'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'type' => 'card',
                'header' => [
                    'title' => 'Konfiguracja szablonów'
                ],
                'data' => [
                    [
                        'type' => 'card-configTable',
                        'data' => [
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'template_name',
                                'description' => 'Nazwa folderu z szablonem',
                                'name' => 'Nazwa szablonu'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'type' => 'card',
                'header' => [
                    'title' => 'Konfiguracja postów'
                ],
                'data' => [
                    [
                        'type' => 'card-configTable',
                        'data' => [
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'textarea_filePath',
                                'description' => 'Ścieżka w której zostają zapisane obrazy dodane podczas edycji posta)',
                                'name' => 'Ścieżka dla zdjęć'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'type' => 'card',
                'header' => [
                    'title' => 'Konfiguracja wyświetlania i zwracania danych'
                ],
                'data' => [
                    [
                        'type' => 'card-configTable',
                        'data' => [
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'mainPage',
                                'description' => 'Główna strona wyświetlana w index.php (domyslnie controller/post), dla kontrolerow controller/{nazwa kontrolera}, dla linków link/{url}, dla postów post/{id}',
                                'name' => 'Główna strona'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'type' => 'card',
                'header' => [
                    'title' => 'Konfiguracja menu panelu administracyjnego'
                ],
                'data' => [
                    [
                        'type' => 'card-configTable',
                        'data' => [
                            [
                                'type' => 'tableDataCheckBootstrap',
                                'configName' => 'APmenu_jumbotron',
                                'description' => 'Opcja edycji telebimu',
                                'name' => 'Telebim'
                            ],
                            [
                                'type' => 'tableDataCheckBootstrap',
                                'configName' => 'APmenu_serwis',
                                'description' => 'Opcja serwisu',
                                'name' => 'Serwis'
                            ],
                            [
                                'type' => 'tableDataCheckBootstrap',
                                'configName' => 'APmenu_menu',
                                'description' => 'Opcja edycji menu strony',
                                'name' => 'Menu'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'type' => 'card',
                'header' => [
                    'title' => 'Konfiguracja użytkowników'
                ],
                'data' => [
                    [
                        'type' => 'card-configTable',
                        'data' => [
                            [
                                'type' => 'tableDataSelectBootstrap',
                                'configName' => 'defaultUserPermissionGroup',
                                'description' => 'Domyślne uprawnienia dla nowych użytkowników',
                                'name' => 'Domyślne uprawnienia',
                                'data' => $permissionData,
                            ]
                        ]
                    ]
                ]
            ],
            [
                'type' => 'card',
                'header' => [
                    'title' => 'Konfiguracja treści panelu administratora'
                ],
                'data' => [
                    [
                        'type' => 'card-configTable',
                        'data' => [
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'adminPanel_title',
                                'description' => 'Tytuł panelu wyświetlany podczas logowania oraz w menu po zalogowaniu',
                                'name' => 'Tytuł panelu'
                            ],
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'adminPanel_loginMessage',
                                'description' => 'Treść wyświetlana nad panelem logowania',
                                'name' => 'Treść logowania'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'type' => 'card',
                'header' => [
                    'title' => 'API'
                ],
                'data' => [
                    [
                        'type' => 'card-configTable',
                        'data' => [
                            [
                                'type' => 'tableDataInput',
                                'configName' => 'api_module',
                                'description' => 'Link do API obsługującego pobieranie oraz aktualizację modułów',
                                'name' => 'API - Moduly'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'type' => 'card',
                'header' => [
                    'title' => 'Panel debugowania'
                ],
                'data' => [
                    [
                        'type' => 'card-configTable',
                        'data' => [
                            [
                                'type' => 'tableDataCheckBootstrap',
                                'configName' => 'debugBar',
                                'description' => 'Opcja włącza panel debugowania dostępny pod przyciskiem <span class="badge badge-primary">`</span>',
                                'name' => 'Panel debugowania',
                                'default' => false
                            ],
                            [
                                'type' => 'tableDataCheckBootstrap',
                                'configName' => 'debugBarForUser',
                                'description' => 'Funkcja pozwala włączyć panel debudowania dla CMS\'a (Nie należy włączać opcji na produkcji)',
                                'name' => 'Panel debugowania',
                                'default' => false
                            ],
                            [
                                'type' => 'tableDataCheckBootstrap',
                                'configName' => 'debugBarDefaultExpandData',
                                'description' => 'Czy tabele mają być domyślnie rozwinięte',
                                'name' => 'Rozwinięcie danych',
                                'default' => false
                            ]
                        ]
                    ]
                ]
            ],
        ],
    ]
]);
core::$model['option']->showOption();
