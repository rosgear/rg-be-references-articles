<?php
/**
 * Этот файл является частью модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\References\Articles\Model;

use Ge\Helper\Json;
use Ge\Db\ActiveRecord;

/**
 * Модель данных типов материала.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package  Rg\Backend\References\Articles\Model
 * @since 1.0
 */
class ArticleType extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function primaryKey(): string
    {
        return 'id';
    }

    /**
     * {@inheritdoc}
     */
    public function tableName(): string
    {
        return '{{reference_articles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function maskedAttributes(): array
    {
        return [
            'id'            => 'id', // идентификатор
            'name'          => 'name', // название
            'description'   => 'description', // описание
            'icon'          => 'icon', // URL-путь значка
            'enabled'       => 'enabled', // доступность
            'all'           => 'all', // просмотр записей всех материалов
            'fields'        => 'fields', // имена полей
            'columns'       => 'columns', // столбцы
            'components'    => 'components', // компоненты 
            'elements'      => 'elements', // элементы дерева
            'tabAttributes' => 'tab_attributes', // элементы вкладки "Атрибуты"
            'tabAnnounce'   => 'tab_announce', // элементы вкладки "Анонс"
            'tabText'       => 'tab_text', // элементы вкладки "Текст"
            'tabSeo'        => 'tab_seo', // элементы вкладки "SEO"
            'tabAdditionally' => 'tab_additionally', // элементы вкладки "Дополнительно"
        ];
    }

    /**
     * Возвращает массив компонентов (конвертирует из JSON-формата).
     * 
     * @return false|array
     */
    public function componentsToArray(): false|array
    {
        if ($this->components) {
            if (is_string($this->components)) {
                $components = Json::decode($this->components);
                return Json::error() ? false : $components;
            } else
            if (is_array($this->components)) {
                return $this->components;
            }
        }
        return [];
    }

    /**
     * Возвращает массив полей (конвертирует из JSON-формата).
     * 
     * @return false|array
     */
    public function fieldsToArray(): false|array
    {
        if ($this->fields) {
            if (is_string($this->fields)) {
                $fields = Json::decode($this->fields);
                return Json::error() ? false : $fields;
            } else
            if (is_array($this->fields)) {
                return $this->fields;
            }
        }
        return [];
    }

    /**
     * Возвращает массив элементов дерева (конвертирует из JSON-формата).
     * 
     * @return false|array
     */
    public function elementsToArray(): false|array
    {
        if ($this->elements) {
            if (is_string($this->elements)) {
                $elements = Json::decode($this->elements);
                return Json::error() ? false : $elements;
            } else
            if (is_array($this->elements)) {
                return $this->elements;
            }
        }
        return [];
    }

    /**
     * Возвращает массив полей (конвертирует из JSON-формата).
     * 
     * @return false|array
     */
    public function columnsToArray(): false|array
    {
        if ($this->columns) {
            if (is_string($this->columns)) {
                $columns = Json::decode($this->columns);
                return Json::error() ? false : $columns;
            } else
            if (is_array($this->columns)) {
                return $this->columns;
            }
        }
        return [];
    }

    /**
     * Возвращает параметры конфигурации вкладки (конвертирует из JSON-формата).
     * 
     * @return false|array
     */
    public function tabToArray(string $name, array $default = []): false|array
    {
        $value = $this->getAttribute('tab' . ucfirst($name));
        if ($value) {
            if (is_string($value)) {
                $arr = Json::decode($value);
                return Json::error() ? false : $arr;
            } else
            if (is_array($value)) {
                return $value;
            }
        }
        return $default;
    }

    /**
     * Возвращает все параметры конфигурации вкладок (конвертирует из JSON-формата).
     * 
     * @return false|array
     */
    public function tabsToArray(): false|array
    {
        $tabs = [
            'attributes'   => [],
            'announce'     => [],
            'text'         => [],
            'seo'          => [],
            'additionally' => []
        ];

        $attributes = $this->tabToArray('attributes');
        if ($attributes === false) {
            return false;
        }
        $tabs['attributes'] = $attributes;

        $attributes = $this->tabToArray('announce');
        if ($attributes === false) {
            return false;
        }
        $tabs['announce'] = $attributes;

        $attributes = $this->tabToArray('text');
        if ($attributes === false) {
            return false;
        }
        $tabs['text'] = $attributes;

        $attributes = $this->tabToArray('seo');
        if ($attributes === false) {
            return false;
        }
        $tabs['seo'] = $attributes;

        $attributes = $this->tabToArray('additionally');
        if ($attributes === false) {
            return false;
        }
        $tabs['additionally'] = $attributes;
        return $tabs;
    }

    /**
     * Удаляет все записи.
     * 
     * @throws \Ge\Db\Adapter\Driver\Exception\CommandException Невозможно выполнить инструкцию SQL.
     */
    public function deleteAll()
    {
        $this->getDb()
            ->createCommand()
                ->truncateTable($this->tableName())
                ->execute();
    }
}
