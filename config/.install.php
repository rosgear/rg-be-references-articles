<?php
/**
 * Этот файл является частью расширения модуля веб-приложения RosGear.
 * 
 * Файл конфигурации установки расширения.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

return [
    'id'          => 'rg.be.references.articles',
    'moduleId'    => 'rg.be.references',
    'name'        => 'Types of materials',
    'description' => 'Types of site articles with appropriate presentation of information',
    'namespace'   => 'Rg\Backend\References\Articles',
    'path'        => '/rg/rg.be.references.articles',
    'route'       => 'article-types',
    'locales'     => ['ru_RU', 'en_GB'],
    'permissions' => ['any', 'view', 'read', 'info'],
    'events'      => [],
    'required'    => [
        ['php', 'version' => '8.2'],
        ['app', 'code' => 'RG CMS'],
        ['module', 'id' => 'rg.be.references']
    ]
];
