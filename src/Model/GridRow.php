<?php
/**
 * Этот файл является частью расширения модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\References\Articles\Model;

use Ge\Panel\Data\Model\FormModel;

/**
 * Модель данных профиля типа материала.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\References\Articles\Model
 * @since 1.0
 */
class GridRow extends FormModel
{
     /**
     * {@inheritdoc}
     */
    public function getDataManagerConfig(): array
    {
        return [
            'tableName'  => '{{reference_articles}}',
            'primaryKey' => 'id',
            'fields'     => [
                ['id'],
                ['name'], // название
                ['enabled'] // доступен
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        $this
            ->on(self::EVENT_AFTER_SAVE, function ($isInsert, $columns, $result, $message) {
                if ($message['success']) {
                    $enabled = (int) $this->enabled;
                    $message['message'] = $this->module->t('Article type «{0}» - ' . ($enabled > 0 ? 'enabled' : 'disabled'), [$this->name]);
                    $message['title']   = $this->t($enabled > 0 ? 'Enabled' : 'Disabled');
                }
                // всплывающие сообщение
                $this->response()
                    ->meta
                        ->cmdPopupMsg($message['message'], $message['title'], $message['type']);
            });
    }
}
