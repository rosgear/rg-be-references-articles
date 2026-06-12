<?php
/**
 * Этот файл является частью расширения модуля веб-приложения RosGear.
 * 
 * Файл конфигурации Карты SQL-запросов.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

return [
    'drop'   => ['{{reference_articles}}'],
    'create' => [
        '{{reference_articles}}' => function () {
            return "CREATE TABLE `{{reference_articles}}` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(255) DEFAULT NULL,
                `description` varchar(255) DEFAULT NULL,
                `icon` varchar(255) DEFAULT NULL,
                `enabled` tinyint(1) unsigned DEFAULT '1',
                `elements` text,
                `components` text,
                `fields` text,
                `columns` text,
                `tab_attributes` text,
                `tab_announce` text,
                `tab_text` text,
                `tab_seo` text,
                `tab_additionally` text,
                `all` tinyint(1) unsigned DEFAULT '0',
                `_updated_date` datetime DEFAULT NULL,
                `_updated_user` int(11) unsigned DEFAULT NULL,
                `_created_date` datetime DEFAULT NULL,
                `_created_user` int(11) unsigned DEFAULT NULL,
                `_lock` tinyint(1) unsigned DEFAULT '0',
                PRIMARY KEY (`id`)
            ) ENGINE={engine} 
            DEFAULT CHARSET={charset} COLLATE {collate}";
        }
    ],

    'run' => [
        'install'   => ['drop', 'create'],
        'uninstall' => ['drop']
    ]
];