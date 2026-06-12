<?php
/**
 * Этот файл является частью расширения модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\References\Articles\Model;

use Ge;
use Ge\Helper\Json;
use Ge\Panel\Data\Model\FormModel;

/**
 * Модель данных профиля типа материала.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\References\Articles\Model
 * @since 1.0
 */
class Form extends FormModel
{
    /**
     * {@inheritdoc}
     */
    public function getDataManagerConfig(): array
    {
        return [
            'tableName' => '{{reference_articles}}',
            'primaryKey' => 'id',
            'useAudit'   => true,
            'fields'     => [
                ['id'],
                ['name'], // название
                ['description'], // описание
                ['icon'], // значок
                ['enabled'], // доступен
                ['all'], // просмотр записей всех материалов
                ['fields'], // поля
                ['elements'], // элементы
                ['components'], // компоненты
                ['columns'], // столбцы
                ['tab_attributes', 'alias' => 'tabAttributes'], // вкладка "Атрибуты"
                ['tab_announce', 'alias' => 'tabAnnounce'], // вкладка "Анонс"
                ['tab_text', 'alias' => 'tabText'], // вкладка "Текст"
                ['tab_seo', 'alias' => 'tabSeo'], // вкладка "SEO"
                ['tab_additionally', 'alias' => 'tabAdditionally'], // вкладка "Дополнительно"
            ],
            // правила форматирования полей
            'formatterRules' => [
                [['enabled', 'all'], 'logic']
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
            ->on(self::EVENT_BEFORE_SAVE, function ($isInsert) {
                // вкладка "Атрибуты"
                if (is_array($this->tabAttributes)) {
                    $this->tabAttributes = json_encode($this->tabAttributes);
                }
                // вкладка "Анонс"
                if (is_array($this->tabAnnounce)) {
                    $this->tabAnnounce = json_encode($this->tabAnnounce);
                }
                // вкладка "Текст"
                if (is_array($this->tabText)) {
                    $this->tabText = json_encode($this->tabText);
                }
                // вкладка "SEO"
                if (is_array($this->tabSeo)) {
                    $this->tabSeo = json_encode($this->tabSeo);
                }
                // вкладка "Дополнительно"
                if (is_array($this->tabAdditionally)) {
                    $this->tabAdditionally = json_encode($this->tabAdditionally);
                }
            })
            ->on(self::EVENT_AFTER_SAVE, function ($isInsert, $columns, $result, $message) {
                /** @var \Ge\Panel\Controller\GridController $controller */
                $controller = $this->controller();
                // всплывающие сообщение
                $this->response()
                    ->meta
                        ->cmdPopupMsg($message['message'], $message['title'], $message['type']);
                // обновить список
                $controller->cmdReloadGrid();
            })
            ->on(self::EVENT_AFTER_DELETE, function ($result, $message) {
                /** @var \Ge\Panel\Controller\GridController $controller */
                $controller = $this->controller();
                // всплывающие сообщение
                $this->response()
                    ->meta
                        ->cmdPopupMsg($message['message'], $message['title'], $message['type']);
                // обновить список
                $controller->cmdReloadGrid();
            });
    }

    /**
     * Возвращает формат атрибутов вкладок.
     * 
     * @return array
     */
    protected function getTabsFormat(): array
    {
        return  [
            'attributes' => [ // вкладка "Атрибуты"
                ['language', 'type' => 'int', 'default' => 0], // язык
                ['template', 'type' => 'string', 'default' => ''], // шаблон материала
                ['pageTemplate', 'type' => 'string', 'default' => ''], // шаблон страницы
                ['slugType', 'type' => 'int', 'default' => 0], // вид ярылка
                ['category', 'type' => 'int', 'default' => 0], // категория
                ['slugEnabled', 'type' => 'int', 'default' => 0], // отображать слаг
                ['imageEnabled', 'type' => 'int', 'default' => 0], // возможность добавить основное изображение
                ['publishDateEnabled', 'type' => 'int', 'default' => 0], // отображать дату публикации
                ['publishOnMain', 'type' => 'int', 'default' => 0], // опубликовать на главной странице
                ['publishInCategories', 'type' => 'int', 'default' => 0], // опубликовать в разделах сайта
                ['publish', 'type' => 'int', 'default' => 0], // опубликовать
                ['title', 'type' => 'string', 'default' => ''], // название вкладки
                ['visible', 'type' => 'int', 'default' => 0], // показать вкладку
            ],
            'announce' => [ // вкладка "Анонс"
                ['title', 'type' => 'string', 'default' => ''],
                ['visible', 'type' => 'int', 'default' => 0],
            ],
            'text' => [ // вкладка "Текст"
                ['title', 'type' => 'string', 'default' => ''],
                ['visible', 'type' => 'int', 'default' => 0],
            ],
            'seo' => [ // вкладка "SEO"
                ['title', 'type' => 'string', 'default' => ''],
                ['visible', 'type' => 'int', 'default' => 0],
                ['metatagEnabled', 'type' => 'int', 'default' => 0], // отображать раздел "Метатег материала"
                ['sitemapEnabled', 'type' => 'int', 'default' => 0], // отображать раздел "Карта сайта"
                ['feedEnabled', 'type' => 'int', 'default' => 0], // отображать раздел "Фид"
                ['indexingEnabled', 'type' => 'int', 'default' => 0], // отображать раздел "Директивы индексирования"
                ['directivesEnabled', 'type' => 'int', 'default' => 0], // отображать раздел "Особые директивы"
            ],
            'additionally' => [ // вкладка "Дополнительно"
                ['title', 'type' => 'string', 'default' => ''],
                ['visible', 'type' => 'int', 'default' => 0], 
                ['fldInSearchCheck', 'type' => 'int', 'default' => 0],  // знач. флажка "Поиск"
                ['fldInSitemapCheck', 'type' => 'int', 'default' => 0],  // знач. флажка "Карта сайта"
                ['fldCachingCheck', 'type' => 'int', 'default' => 0],  // знач. флажка "Кэширование"
                ['fldIndexShow', 'type' => 'int', 'default' => 0],  // поле "Порядок"
                ['fldHitsShow', 'type' => 'int', 'default' => 0],  // поле "Количество посещений"
                ['fldTagsShow', 'type' => 'int', 'default' => 0],  // поле "Метки"
                ['fldInSearchShow', 'type' => 'int', 'default' => 0],  // флажок "Поиск"
                ['fldInSitemapShow', 'type' => 'int', 'default' => 0],  // флажок "Карта сайта"
                ['fldCachingShow', 'type' => 'int', 'default' => 0],  // флажок "Кэширование"
            ],
        ];
    }

    /**
     * Выполняет форматирование значений атрибутов в указанном формате.
     * 
     * @param array $format Формат атрибутов вкладки.
     * @param array $attributes Атрибуты в виде пар "ключ - значение".
     * 
     * @return array
     */
    protected function formatTabs(array $format, array $attributes): array
    {
        $result = [];
        foreach ($format as $attribute) {
            $name = $attribute[0];

            if (isset($attributes[$name])) {
                $value = $attributes[$name];
                settype($value, $attribute['type']);
                $result[$name] = $value;
            } else
                $result[$name] = $attribute['default'];
        }
        return $result;
    }

    /**
     * Выполняет добавление атрибутов формата для указанного ключа.
     * 
     * @param string $key Ключ атрибутов, например: 'key[name]'.
     * @param array $format Формат атрибутов вкладки.
     * @param array $attributes Атрибуты в виде пар "ключ - значение".
     * 
     * @return void
     */
    protected function addAttributesFromFormat(string $key, array $format, array $attributes): void
    {
        foreach ($format as $attribute) {
            $name = $attribute[0];

            $value = $attributes[$name] ?? $attribute['default'];

            $this->attributes[$key . '[' . $name . ']'] = $value;
        }
    }

    /**
     * Возвращает значение для выпадающего списка категорий материалов.
     * 
     * @param  int|string $itemId Идентификатор элемента выпадающего списка.
     * 
     * @return null|object
     */
    protected function getCategoryComboItem($itemId): ?object
    {
        if ($itemId) {
            /** @var \Rg\Backend\ArticleCategories\Model\Category $category */
            $category = Ge::$app->modules->getModel('Category', 'rg.be.article_categories');
            return $category ? $category->selectByPk($itemId) : null;
        }
        return null;
    }

    /**
     * Возвращает значение для выпадающего списка языков.
     * 
     * @param string $itemId Идентификатор элемента выпадающего списка.
     * 
     * @return array
     */
    protected function getLanguageComboItem($itemId): ?array
    {
        if ($itemId) {
            $language = Ge::$app->language->available->getBy($itemId, 'code');
            return $language ? $language : null;
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeLoad(array &$data): void
    {
        /** @var array $format Формат атрибутов вкладок */
        $format = $this->getTabsFormat();

        // вкладка "Атрибуты"
        $data['tabAttributes'] = $this->formatTabs($format['attributes'], $data['tabAttributes'] ?? []);

        // вкладка "Анонс"
        $data['tabAnnounce'] = $this->formatTabs($format['announce'], $data['tabAnnounce'] ?? []);

        // вкладка "Текст"
        $data['tabText'] = $this->formatTabs($format['text'], $data['tabText'] ?? []);

        // вкладка "SEO"
        $data['tabSeo'] = $this->formatTabs($format['seo'], $data['tabSeo'] ?? []);

        // вкладка "Дополнительно"
        $data['tabAdditionally'] = $this->formatTabs($format['additionally'], $data['tabAdditionally'] ?? []);
    }

    /**
     * Устанавливает значение атрибуту "columns".
     * 
     * @param mixed $value
     * 
     * @return void
     */
    public function setColumns(mixed $value): void
    {
        if ($value) {
            if (is_string($value)) {
                $value = Json::tryDecode($value);
                if ($value === false) {
                    // TODO: debug
                    $value = [];
                }
            }
        } else
            $value = [];

        $columns = [];
        // значения атрибутов "dataIndex" столбцов сетки по умолчанию
        $defaultColumns = [
            'publishDate', 'index', 'header', 'categoryName', 'slug', 'slugType', 'languageName', 
            'template', 'pageTemplate', 'url', 'hits', 'publish', 'caching', 'indexing'
        ];
        foreach ($defaultColumns as $name) {
            if (isset($value[$name])) {
                $column = $value[$name];
                $columns[$name] = [
                    'text'       => $column['text'] ?? '',
                    'tooltip'    => $column['tooltip'] ?? '',
                    'width'      => (int) ($column['width'] ?? 0),
                    'visible'    => (bool) ($column['visible'] ?? false),
                    'sortable'   => (bool) ($column['sortable'] ?? false),
                    'filterable' => (bool) ($column['filterable'] ?? false),
                    'enabled'    => (bool) ($column['enabled'] ?? false)
                ];
            }
        }

        $this->attributes['columns'] = $columns;
    }

    /**
     * Возращает значение для сохранения в поле "columns".
     * 
     * @return string
     */
    public function unColumns(): string
    {
        return  Json::encode((array) $this->columns);
    }

    /**
     * Возвращает значение атрибута "columns" элементу интерфейса формы.
     * 
     * @param null|array $value
     * 
     * @return array
     */
    public function outColumns($value): ?array
    {
        if ($value) {
            $columns = $value;
            foreach ($columns as $columnName => $properties) {
                foreach ($properties as $name => $value) {
                    $this->attributes["columns[$columnName][$name]"] = $value;
                }
            }
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function processing(): void
    {
        parent::processing();

        /** @var array $format Формат атрибутов вкладок */
        $format = $this->getTabsFormat();
        /** @var array $emptyComboItem Пустой элемент списка */
        $emptyComboItem = [
            'type'  => 'combobox',
            'value' => 0,
            'text'  => Ge::t(BACKEND, '[None]')
        ];

        // вкладка "Атрибуты"
        if ($this->tabAttributes) {
            $attributes = json_decode($this->tabAttributes, true);
            $this->addAttributesFromFormat('tabAttributes', $format['attributes'], $attributes);

            /** @var null|array $item Язык */
            $item = $this->getLanguageComboItem($this->getAttribute('tabAttributes[language]'));
            if ($item)
                $value = [
                    'type'  => 'combobox', 
                    'value' => $item['code'],
                    'text'  => $item['shortName'] . ' (' . $item['tag'] . ')'
                ];
            else
                $value = $emptyComboItem;
            $this->setAttribute('tabAttributes[language]', $value);

            /** @var Object $item Категория материала */
            $item = $this->getCategoryComboItem($this->getAttribute('tabAttributes[category]'));
            if ($item)
                $value = [
                    'type'  => 'combobox', 
                    'value' => $item->id, 
                    'text'  => $item->name
                ];
            else
                $value = $emptyComboItem;
            $this->setAttribute('tabAttributes[category]', $value);
        }

        // вкладка "Анонс"
        if ($this->tabAnnounce) {
            $attributes = json_decode($this->tabAnnounce, true);
            $this->addAttributesFromFormat('tabAnnounce', $format['announce'], $attributes);
        }

        // вкладка "Текст"
        if ($this->tabText) {
            $attributes = json_decode($this->tabText, true);
            $this->addAttributesFromFormat('tabText', $format['text'], $attributes);
        }

        // вкладка "SEO"
        if ($this->tabSeo) {
            $attributes = json_decode($this->tabSeo, true);
            $this->addAttributesFromFormat('tabSeo', $format['seo'], $attributes);
        }

        // вкладка "Дополнительно"
        if ($this->tabAdditionally) {
            $attributes = json_decode($this->tabAdditionally, true);
            $this->addAttributesFromFormat('tabAdditionally', $format['additionally'], $attributes);
        }
    }
}
