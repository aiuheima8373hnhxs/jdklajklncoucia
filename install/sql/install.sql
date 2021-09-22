/* AP_groupPermission */
CREATE TABLE `AP_groupPermission` (
    `id` int(24) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `permission` text NOT NULL,
    PRIMARY KEY (`id`)
);
INSERT INTO `AP_groupPermission` (`id`, `name`, `permission`) VALUES
    (1, 'Administrator', '[\"all_granted\"]'),
    (2, 'Użytkownik', '[]');

/* AP_user */
CREATE TABLE `AP_user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `login` varchar(30) NOT NULL,
    `password` varchar(50) NOT NULL,
    `email` varchar(50) DEFAULT NULL,
    `name` varchar(128) DEFAULT NULL,
    `avatar` varchar(256) DEFAULT NULL,
    `permission` int(24) NOT NULL DEFAULT '1',
    `blocked` int(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
);

/* config */
CREATE TABLE `config` (
    `id` int(24) NOT NULL AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    `value` text NOT NULL,
    PRIMARY KEY (`id`)
);
INSERT INTO `config` (`id`, `name`, `value`) VALUES
    (1, 'adminPanel_loginMessage', 'Zaloguj się do panelu administracyjnego <a href=\"https://krzysztofzylka.pl/\">FourCMS</a>'),
    (2, 'adminPanel_title', 'Admin Panel'),
    (3, 'APmenu_jumbotron', '1'),
    (4, 'APmenu_menu', '1'),
    (5, 'APmenu_serwis', '0'),
    (6, 'defaultUserPermissionGroup', '2'),
    (7, 'header_charset', 'utf-8'),
    (8, 'header_description', ''),
    (9, 'header_google_site_verification', ''),
    (10, 'header_keywords', 'FourCMS, FourFramework, Zarządzanie treścią'),
    (11, 'header_title', 'Nagłówek strony'),
    (12, 'mainPage', 'controller/post'),
    (13, 'menuCard_show', '1'),
    (14, 'menuCard_text', 'Tytuł'),
    (15, 'menuCard_title', 'Treść karty'),
    (16, 'template_name', 'defaultBlog'),
    (17, 'textarea_filePath', 'images/'),
    (18, 'title', 'Nagłówek'),
    (19, 'version', '0.2.8 Beta');

/* jumbotron */
CREATE TABLE `jumbotron` (
    `name` varchar(128) NOT NULL,
    `value` text NOT NULL,
    PRIMARY KEY (`name`)
);
INSERT INTO `jumbotron` (`name`, `value`) VALUES
    ('header', 'Nagłówek telebimu'),
    ('show', '1'),
    ('text', 'Treść telebimu'),
    ('url', '#');

/* menu */
CREATE TABLE `menu` (
    `id` int(12) NOT NULL AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    `link` varchar(255) NOT NULL,
    `position` int(15) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
);
INSERT INTO `menu` (`id`, `name`, `link`, `position`) VALUES
    (1, 'Strona główna', 'index.php', 0);

/* permissionList */
CREATE TABLE `permissionList` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `permName` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `description` text NOT NULL,
    PRIMARY KEY (`id`)
);
INSERT INTO `permissionList` (`permName`, `name`, `description`) VALUES
    ('all_granted', 'Wszystkie uprawnienia', 'Wszystkie uprawnienia'),
    ('post', 'Posty', 'Dostęp do wszystkich funkcji postów'),
    ('jumbotron', 'Telebim', 'Dostęp do wszystkich funkcji telebimu'),
    ('menu', 'Menu', 'Dostęp do wszystkich funkcji menu'),
    ('permissionUserEdit', 'Edycja uprawnień użytkownika', 'Opcja ta zezwala użytkownikowi na edycję uprawnień innych użytkowników'),
    ('option_editTemplate', 'Edycja szablonów', 'Opcja pozwala na edycję szablonów strony'),
    ('option_editConfig', 'Edycja konfiguracji', 'Opcja ta pozwala na edycję konfiguracji strony'),
    ('option_users', 'Użytkownicy', 'Dostęp do wszystkich funkcji strony Użytkownicy'),
    ('option_usersAdd', 'Dodanie użytkowników', 'Dostęp do opcji dodania nowego użytkownika'),
    ('option_permissionEdit', 'Zarządzanie uprawnieniami', 'Opcja umożliwiająca edycję/dodanie nowej grupy uprawnień'),
    ('service', 'Serwis', 'Dostęp do wszystkich funkcji serwisu'),
    ('service_library', 'Biblioteki', 'Dostęp do informacji o bibliotekach'),
    ('service_module', 'Moduły', 'Dostęp do informacji o modułach'),
    ('service_logs', 'Logi', 'Dostęp do logów serwisu'),
    ('service_phpinfo', 'PHPInfo', 'Dostęp do informacji o PHP'),
    ('module', 'Moduły', 'Dostęp do Panelów Administracyjnych zainstalowanych modułów'),
    ('otherUser', 'Przeglądanie użytkowników', 'Przeglądanie profili innych użytkowników'),
    ('option_template', 'Zmiana szablonu', 'Zmiana szablonu strony'),
    ('option_module', 'Moduły (Ustawienia)', 'Dostęp do modułów (w ustawieniach)'),
    ('moduleInstall', 'Instalacja modułów', 'Uprawnienie pozwala na instalację modułów z plików ZIP'),
    ('blockUser', 'Zablokowanie/Odblokowanie użytkowników', 'Pozwolenie na zablokowanie/odblokowanie użytkownika'),
    ('moduleAdd', 'Strona instalacyjna modułów', 'Uprawnienie pozwala na dostęp do strony instalacyjnej modułów z serwera');

/* post */
CREATE TABLE `post` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(80) NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `text` text NOT NULL,
    `user` int(24) NOT NULL,
    `url` varchar(128) NOT NULL,
    `type` varchar(255) NOT NULL DEFAULT 'post',
    `hidden` int(1) NOT NULL DEFAULT '0',
	`showMetaData` int(1) NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`)
);
INSERT INTO `post` (`id`, `title`, `date`, `text`, `user`, `url`, `type`, `hidden`) VALUES
    (1, 'Strona główna', '0000-00-00 00-00-00', 'Witaj w pierwszym poście twojego CMSa', 1, 'auto', 'post', 0);

/* widget */
CREATE TABLE `widget` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `userID` int(24) NOT NULL,
  `uniqueIDWidget` varchar(32) NOT NULL,
  `position` int(24) NOT NULL
    PRIMARY KEY (`id`)
);