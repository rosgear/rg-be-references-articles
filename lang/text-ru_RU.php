<?php
/**
 * Этот файл является частью расширения модуля веб-приложения RosGear.
 * 
 * Пакет русской локализации.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

return [
    '{name}'        => 'Типы материалов',
    '{description}' => 'Виды статей сайта с соответствующим представлением информации',
    '{permissions}' => [
        'any'  => ['Полный доступ', 'Просмотр и внесение изменений в типы материалов'],
        'view' => ['Просмотр', 'Просмотр типов материалов'],
        'read' => ['Чтение', 'Чтение ипов материалов']
    ],

    // Grid: контекстное меню записи
    'Edit record' => 'Редактировать',
    // Grid: столбцы
    'Name' => 'Название',
    'Description' => 'Описание',
    'Enabled' => 'Доступен',
    'Icon' => 'Значок',
    'yes' => 'да',
    'no' => 'нет',
    // Grid: всплывающие сообщения / заголовок
    'Disabled' => 'Скрыт',
    'Article type «{0}» - enabled' => 'Тип материала «{0}» - <b>доступен</b>.',
    'Article type «{0}» - disabled' => 'Тип материала «{0}» - <b>скрыт</b>.',

    // Form
    '{form.title}' => 'Добавление типа материала',
    '{form.titleTpl}' => 'Изменение типа метериала "{name}"',
    // Form: поля
    'Attributes' => 'Атрибуты',
    'All articles' => 'Все материалы',
    'if installed, all material records will be displayed regardless of their type' 
        => 'если установлен, то буду отображаться все записи материалов независимо от их типа',
    // Form: поля / интерфейс списка
    'Column "Date of publication"' => 'Столбец "Дата публикации"',
    'Column "Index number"' => 'Столбец "Порядковый номер"',
    'Column "Header"' => 'Столбец "Заголовок"',
    'Column "Category"' => 'Столбец "Категория (раздел) материала"',
    'Column "Slug"' => 'Столбец "Ярлык (слаг)"',
    'Column "Slug type"' => 'Столбец "Вид ярлыка"',
    'Column "Language"' => 'Столбец "Язык"',
    'Column "Template"' => 'Столбец "Шаблон"',
    'Column "Page template"' => 'Столбец "Шаблон страницы"',
    'Column "Anchor"' => 'Столбец "Ссылка на страницу"',
    'Column "Number of hits"' => 'Столбец "Количество посещений"',
    'Column "Published"' => 'Столбец "Опубликовано"',
    'Column "Caching"' => 'Столбец "Кэширование материала"',
    'Column "Indexing"' => 'Столбец "Индексирование"',
    'Grid Interface' => 'Интерфейс Списка',
    'Column name' => 'Название столбца (если значение не указано, будет применяться значение по умолчанию)',
    'Tootlip' => 'Подсказка',
    'Column tooltip' => 'Подсказка заголовка столбца (если значение не указано, будет применяться значение по умолчанию)',
    'Width' => 'Ширина, пкс',
    'Column width' => 'Ширина столбца в пикселях (если значение не указано, будет применяться значение по умолчанию)',
    'Sortable' => 'Сортировать',
    'Filterable' => 'Фильтрировать',
    'Enabled' => 'Доступен',
    // Form: поля / интерфейс формы
    'Form Interface' => 'Интерфейс Формы',
    'Tabs' => 'Вкладки',
    'Tab fields (default)' => 'Поля вкладки (значения по умолчанию)',
    'Tab fields (show)' => 'Поля вкладки (отображать)',
    'Tab "Attributes"' => 'Вкладка "Атрибуты"',
    'Language' => 'Язык',
    'The language (if selected) will be automatically added to the site material' 
        => 'Язык (если выбран), будет автоматически добавлен к материалу сайта и будет скрыт при отображении формы материала',
    'Template' => 'Шаблон',
    'The material display template (if selected) will be automatically added to the site material' 
        => 'Шаблон отображения материала (если выбран), будет автоматически добавлен к материалу сайта и будет скрыт при отображении формы материала',
    'Page template' => 'Шаблон страницы',
    'The material page template (if selected) will be automatically added to the site material' 
        => 'Шаблон страницы материала (если выбран), будет автоматически добавлен к материалу сайта и будет скрыт при отображении формы материала',
    'Slug type' => 'Вид ярлыка',
    'The site content URL display view (if selected) will be automatically added to the site content and will be hidden when the content form is displayed' 
        => 'Вид отображения URL-адреса материала сайта (если выбран), будет автоматически добавлен к материалу сайта и будет скрыт при отображении формы материала',
    'Static' => 'Статический',
    'Dynamic' => 'Динамический',
    'Main' => 'Основной',    
    '[None]' => '[ без выбора ]',
    'Category' => 'Категория',
    'The category (section) of the site material (if selected) will be automatically added to the site material and will be hidden when the material form is displayed' 
        => 'Категория (раздел) материала сайта (если выбрана), будет автоматически добавлен к материалу сайта и будет скрыт при отображении формы материала',
    'URL path (slug)' => 'Ярлык (слаг)',
    'Image' => 'Изображение',
    'Publication date' => 'Дата публикации',
    'Show option to select publish flags' => 'Отображать возможность выбора флажков публикации',
    'on the main page of the site' => 'на главной странице сайта',
    'in site sections' => 'в разделах сайта',
    'on the site' => 'на сайте',
    'Tab' => 'Вкладка',
    'Name' => 'Название',
    'Tab name' => 'Название вкладки',
    'Show' => 'Отображать',
    'Tab "Announce"' => 'Вкладка "Анонс"',
    'Tab "Text"' => 'Вкладка "Текст"',
    'Tab "SEO"' => 'Вкладка "SEO"',
    'Section "Article metatag"' => 'Раздел "Метатег материала"',
    'Section "Sitemap"' => 'Раздел "Карта сайта"',
    'Section "Feed"' => 'Раздел "Фид"',
    'Section "Indexing directives"' => 'Раздел "Директивы индексирования"',
    'Section "Special directives"' => 'Раздел "Особые директивы"',
    'Tab "Additionally"' => 'Вкладка "Дополнительно"',
    'Field "Index"' => 'Поле "Порядок"',
    'Field "Number of hits"' => 'Поле "Количество посещений"',
    'Field "Tags"' => 'Поле "Метки"',
    'Checkbox "Search"' => 'Флажок "Поиск"',
    'Checkbox "Sitemap"' => 'Флажок "Карта сайта"',
    'Checkbox "Caching"' => 'Флажок "Кэширование"',
    // Form: поля / элементы формы
    'Material type attributes' => 'Атрибуты типа материала',
    'Form elements' => 'Элементы Формы',
    'Material type form elements' => 'Элементы формы типа материала',
    'Properties' => 'Свойства',
    'Add interface element' => 'Добавить элемент интерфейса',
    'Add' => 'Добавить',
    'Add to selected element' => 'Добавить в выбранный элемент',
    'You need to select a element' => 'Вам нужно выбрать элемент',
    'Remove selected item' => 'Удалить выбранный элемент',
    'Remove all items' => 'Удалить все элементы',
    'Remove all properties' => 'Удалить все свойства',
    'Remove selected property' => 'Удалить выделенное свойство',
    'You need to select a property' => 'Необходимо выбрать свойство!',
    'You need to select a element' => 'Необходимо выбрать элемент!',
    'The selected property cannot be deleted' => 'Невозможно удалить выбранное свойство!',
    'Give properties names' => 'Указать свойствам имена',

    // Window
    'Adding an interface element' => 'Добавление элемента интерфейса',
    'Adding an element property' => 'Добавление свойства элементу',
    'Interface element' => 'Элемент интерфейса',
    'Cancel' => 'Отмена',
    'Value' => 'Значение'
];