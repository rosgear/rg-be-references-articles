/*!
 * Контроллер представления элементов типа метериала.
 * Расширение "Типы материалов".
 * Модуль "Справочники".
 * Copyright 2015 RosGear. Anton Tivonenko <anton.tivonenko@gmail.com>
 * https://rosgear.ru/license/
 */

Ext.define('Rg.be.references.articles.ElementsController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.rg-be-references-articles-elements',

    /**
     * @cfg {null|Ext.window.Window}
     * Окно добавления элемента.
     */
    elementWindow: null,

    /**
     * @cfg {null|Ext.window.Window}
     * Окно добавления свойств элементу.
     */
    propertyWindow: null,

    /**
     * Возвращает сетку свойств.
     * @return {Ext.grid.property.Grid}
     */
    getProperties: () => { return Ext.getCmp('rg-references-articles__properties'); },

    /**
     * Возвращает дерево элементов.
     * @return {Ext.tree.Panel}
     */
    getElements: () => { return Ext.getCmp('rg-references-articles__elements'); },

    /**
     * Проверяет, выбран ил элемент из дерева.
     * @return {Boolean}
     */
    isElementSelected: function () {
        let count = this.getElements().getSelectionModel().getCount();
        return count > 0;
    },

    /**
     * Возвращает выделенный элемент дерева.
     * @return {Object}
     */
    getSelectedElement: function () {
        let model = this.getElements().getSelectionModel();
        let count = model.getCount();
        if (count == 0) return null;

        return model.getSelection()[0];
    },

    /**
     * Нажатие на кнопку "Удалить все элементы" панели инструментов.
     * @param {Ext.button.Button} me
     * @param {Event} e Событие.
     * @param {Object} eOpts Параметры слушателя.
     */
    onBtnRemoveElements: function (me, e, eOpts) {
        let tree = this.getElements(),
            root = tree.getRootNode();

        root.removeAll();
        tree.getStore().reload();

        this.getProperties().setSource({});
    },

    /**
     * Нажатие на кнопку "Удалить все свойства" панели инструментов.
     * @param {Ext.button.Button} me
     * @param {Event} e Событие.
     * @param {Object} eOpts Параметры слушателя.
     */
    onBtnRemoveProperties: function (me, e, eOpts) {
        if (!this.isElementSelected()) return;

        let grid = this.getProperties(),
            name = grid.getProperty('elementName');

        grid.setSource({elementName: name ? name : ''});
    },

    /**
     * Нажатие на кнопку "Удалить элемент" панели инструментов.
     * @param {Ext.button.Button} me
     * @param {Event} e Событие.
     * @param {Object} eOpts Параметры слушателя.
     */
    onBtnRemoveElement: function (me, e, eOpts) {
        let tree = this.getElements(),
            model = tree.getSelectionModel();

        let count = model.getCount();
        if (count == 0) {
            Ext.Msg.warning(me.msgMustSelect);
            return;
        }

        let nodes = model.getSelection();
        for (let node of nodes) {
            let parentNode = node.parentNode;
            node.removeAll();
            parentNode.removeChild(node);
        }

        this.getProperties().setSource({});
    },

    /**
     * Нажатие на кнопку "Удалить свойство" панели инструментов.
     * @param {Ext.button.Button} me
     * @param {Event} e Событие.
     * @param {Object} eOpts Параметры слушателя.
     */
    onBtnRemoveProperty: function (me, e, eOpts) {
        let grid = this.getProperties(),
            rows = grid.getSelectionModel().getSelection();

        if (rows.length == 0) {
            Ext.Msg.warning(me.msgMustSelect);
            return;
        }
        let name = rows[0].get('name');
        if (name === 'elementName') {
            Ext.Msg.warning(me.msgRemoveError);
            return;
        }
        grid.removeProperty(name);
    },

    /**
     * Нажатие на кнопку "Добавить элемент" пункта меню.
     * @param {Ext.menu.Item|Ext.button.Button} me
     * @param {Event} e Событие.
     * @param {Object} eOpts Параметры слушателя.
     */
     onAddElement: function (me, e, eOpts) {
        if (this.elementWindow == null) {
            this.elementWindow = Ext.create(me.parentMenu ? me.parentMenu.ownerCmp.window : me.window);
        }

        this.elementWindow.down('form').reset();
        this.elementWindow.appendToNode = this.getElements().getRootNode();
        this.elementWindow.show();
    },

    /**
     * Нажатие на кнопку "Добавить свойство".
     * @param {Ext.button.Button} me
     * @param {Event} e Событие.
     * @param {Object} eOpts Параметры слушателя.
     */
     onAddProperty: function (me, e, eOpts) {
        let tree = this.getElements(),
        model = tree.getSelectionModel();

        let count = model.getCount();
        if (count == 0) {
            Ext.Msg.warning(me.msgMustSelectElement);
            return;
        }

        if (this.propertyWindow == null) {
            this.propertyWindow = Ext.create(me.window);
        }

        this.propertyWindow.down('form').reset();
        this.propertyWindow.show();
    },

    /**
     * Нажатие на кнопку "Добавить в выбранный элемент" пункта меню.
     * @param {Ext.menu.Item} me
     * @param {Event} e Событие.
     * @param {Object} eOpts Параметры слушателя.
     */
    onAddElementTo: function (me, e, eOpts) {
        if (this.elementWindow == null) {
            this.elementWindow = Ext.create(me.parentMenu ? me.parentMenu.ownerCmp.window : me.window);
        }

        let node = this.getSelectedElement();
        if (node) {
            this.elementWindow.down('form').reset();
            this.elementWindow.appendToNode = node;
            this.elementWindow.show();
        } else
            Ext.Msg.warning(me.msgMustSelect);
    },

    onPropertyChange: function (source, recordId, value, oldValue, eOpts)  {
        let node = this.getSelectedElement();

        if (node) {
            if (Ext.isDefined(source.elementName)) {
                node.set('text', source.elementName);
            }
            node.set('properties', source);
        }
    },

    /**
     * Выделение узла (элемента интерфейса) дерева.
     * @param {Ext.selection.RowModel}
     * @param {Ext.data.Model} record Выделенная запись.
     * @param {Number} index Порядковый номер
     * @param {Object} eOpts Параметры слушателя.
     */
    onSelectNode: function (me, record, index, eOpts)  {
        let grid = this.getProperties();

        if (Ext.isDefined(record.data.properties))
            grid.setSource(record.data.properties);
        else
            grid.setSource({});  
    },

    /**
     * Нажатие на кнопку "Добавить элемент" окна элемента.
     * @param {Ext.button.Button} me
     * @param {Event} e Событие.
     * @param {Object} eOpts Параметры слушателя.
     */
    onBtnAddElement: function (me, e, eOpts) {
        let form = me.up('form');
        if (form.isValid()) {
            let elementName = form.getForm().findField('elementName'),
                elementCombo = form.getForm().findField('elementCombo'),
                element = elementCombo.getSelection(),
                properties = element.get('properties');

            properties = properties ? Ext.decode(properties) : {};
            properties.elementName = elementName.getValue();
            properties.xtype = element.get('type');

            let window = me.up('window');
            window.appendToNode.appendChild({
                text: elementName.getValue(),
                icon: element.get('icon'),
                leaf: true,
                expanded: false,
                properties: properties,
                isField: parseInt(element.get('isField'))
            });
            window.appendToNode.expand();
            window.hide();
        }
    },

    /**
     * Нажатие на кнопку "Добавить свойство" окна элемента.
     * @param {Ext.button.Button} me
     * @param {Event} e Событие.
     * @param {Object} eOpts Параметры слушателя.
     */
     onBtnAddProperty: function (me, e, eOpts) {
         let form = me.up('form');
        if (form.isValid()) {
            let propName = form.getForm().findField('propertyName'),
                propValue = form.getForm().findField('propertyValue');

            this.getProperties().setProperty(propName.getValue(), propValue.getValue(), true);
            me.up('window').hide();
        }
    },

    /**
     * Нажатие на кнопку "Отмена" окна элемента.
     * @param {Ext.button.Button} me
     * @param {Event} e Событие.
      *@param {Object} eOpts Параметры слушателя.
     */
    onBtnCloseWindow: function (me, e, eOpts) {
        me.up('form').reset();
        me.up('window').hide();
    },

    /**
     * Нажатие на кнопку "Указать имена свойствам" панели инструментов.
     * @param {Ext.button.Button} me
     * @param {Boolean} pressed Кнока нажата.
      *@param {Object} eOpts Параметры слушателя.
     */
    onBtnToggleProperties: function (me, pressed, eOpts) {
        let grid = this.getProperties();

        if (!Ext.isDefined(grid.namesConfig)) {
            grid.namesConfig = {};
            for (property in grid.sourceConfig) {
                grid.namesConfig[property] = grid.sourceConfig[property]['displayName'];
            }
        }

        if (pressed) {
            for (property in grid.sourceConfig) {
                grid.sourceConfig[property]['displayName'] = property;
            }
        } else {
            for (property in grid.namesConfig) {
                grid.sourceConfig[property]['displayName'] = grid.namesConfig[property];
            }
        }
        grid.getStore().load();
    },

    /**
     * Унижчтожает контроллер.
     */
    destroy: function() {
        if (this.elementWindow) {
            this.elementWindow.destroy();
        }
        if (this.propertyWindow) {
            this.propertyWindow.destroy();
        }

        this.callParent();
    }
});