<?php
/**
 * Этот файл является частью расширения модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\References\Articles\Controller;

use Ge;
use Ge\Panel\Helper\ExtCombo;
use Ge\Mvc\Module\BaseModule;
use Ge\Panel\Widget\EditWindow;
use Ge\Panel\Controller\FormController;

/**
 * Контроллер формы типа материала.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\References\Articles\Controller
 * @since 1.0
 */
class Form extends FormController
{
    /**
     * {@inheritdoc}
     * 
     * @var BaseModule|\Rg\Backend\References\Articles\Extension
     */
    public BaseModule $module;

    /**
     * Возвращает все свойства элементов интерфейса.
     * 
     * @return array
     */
    protected function getSourceConfig(): array
    {
        $config = [];

        /** @var null|\Rg\Backend\References\Properties\Extension $extension */
        $extension = Ge::$app->extensions->create('rg.be.references.properties');
        if ($extension) {
            /** @var null|\Rg\Backend\References\Properties\Model\Property $properties */
            $properties = $extension->getModel('Property');
            if ($properties) {
                $rows = $properties->fetchAll();
                foreach ($rows as $row) {
                    $config[$row['property']] = [
                        'displayName' => $extension->t($row['name'] ?? SYMBOL_NONAME),
                        'tooltip'     => $extension->t($row['name'] ?? $row['property']),
                        'type'        => $row['type'] ?? 'string'
                    ];
                }
            }
        }
        return $config;
    }

    /**
     * {@inheritdoc}
     */
    public function createWidget(): EditWindow
    {
        /** @var EditWindow $window */
        $window = parent::createWidget();

        // панель формы (Ge.view.form.Panel GeJS)
        $window->form->autoScroll = true;
        $window->form->router->route = $this->module->route('/form');
        $window->form->loadJSONFile('/form', 'items', [
            // сетка свойств элементов материала
            '@sourceConfig' => $this->getSourceConfig(),
            // выпадающий список шаблонов шаблонов материала
            '@articleTemplates' => ExtCombo::themeViews(
                '#Template', 
                'tabAttributes[template]', 
                FRONTEND, 
                ['type' => 'article'],
                [],
                [
                    'labelWidth' => 170,
                    'width'      => 450,
                    'tooltip'    => '#The material display template (if selected) will be automatically added to the site material'
                ]
            ),
            // выпадающий список шаблонов страниц
            '@pageTemplates' => ExtCombo::themeViews(
                '#Page template', 
                'tabAttributes[pageTemplate]', 
                FRONTEND, 
                ['type' => 'page'],
                [],
                [
                    'labelWidth' => 170,
                    'width'      => 450,
                    'tooltip'    => '#The material page template (if selected) will be automatically added to the site material'
                ]
            )
        ]);

        // окно компонента (Ext.window.Window Sencha ExtJS)
        $window->width = 900;
        $window->height = 600;
        $window->responsiveConfig = [
            'height < 600' => ['height' => '99%'],
        ];
        $window->resizable = true;
        $window->maximizable = true;
        $window->layout = 'fit';
        $window
            ->setNamespaceJS('Rg.be.references.articles')
            ->addRequire('Ge.view.form.field.Field')
            ->addRequire('Ge.view.grid.property.Grid')
            ->addRequire('Rg.be.references.articles.Fields')
            ->addRequire('Rg.be.references.articles.ElementsController');
        return $window;
    }
}
