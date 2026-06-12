/*!
 * Компонент формы: "Скрытое поле элементов", "Скрытое поле полей формы", "Скрытое поле компонентов".
 * Расширение "Типы материалов".
 * Модуль "Справочники".
 * Copyright 2015 RosGear. Anton Tivonenko <anton.tivonenko@gmail.com>
 * https://rosgear.ru/license/
 */

/**
 * @class Rg.be.references.articles.ElementsField
 * @extends Ext.form.field.Hidden
 * Компонент скрытого поля для получения элементов дерева в формате JSON.
 */
Ext.define('Rg.be.references.articles.ElementsField', {
    extend: Ext.form.field.Hidden,
    xtype: 'rg-be-references-articles-efield',

    /**
     * @cfg {Ext.tree.Panel} treeId
     * Дерево элементов.
     */
    treeId: null,

    /**
     * Возвращает все узла дерева элементов с дополнительными свойствами.
     * @param {Ext.tree.Node} node
     * @return {Array}
     */
    getTreeNodes: function (node) {
        var nodes = [];
            
        for (let child of node.childNodes) {
            let childNodes = this.getTreeNodes(child);
            nodes.push({
                icon: child.data.icon,
                text: child.data.text,
                leaf: childNodes.length == 0,
                isField: child.data.isField,
                children: childNodes,
                properties: child.data.properties || {},
                expanded: childNodes.length > 0
            });
        }
        return nodes;
    },

    /**
     * Возвращает значение, которое будет включено в стандартную отправку формы для 
     * этого поля. 
     */
    getSubmitValue: function () {
        let tree = Ext.getCmp(this.treeId);
        if (!Ext.isDefined(tree)) {
            return null;
        }
        // если сетка не отобразилась, значит изменений в ней нет
        if (!tree.rendered) {
            return null;
        }

        let root = tree.getRootNode();
        return Ext.util.JSON.encode(this.getTreeNodes(root));
    },

    /**
     * Устанавливает значение в поле, декодирует значение из формата JSON в  
     * массив записей с добавлением в хранилище сетки.
     * @param {Object} value Значение для установки.
     * @return {Ge.view.form.field.GridStore} this
     */
    setValue: function (value) {
        if (value) {
            let tree = Ext.getCmp(this.treeId),
                root = tree.getRootNode();   
            root.appendChild(Ext.util.JSON.decode(value));
        }
        return this.callParent([value]);
    }
});


/**
 * @class Rg.be.references.articles.FieldsField
 * @extends Ext.form.field.Hidden
 * Компонент скрытого поля для получения полей из дерева элементов в формате JSON.
 */
Ext.define('Rg.be.references.articles.FieldsField', {
    extend: Ext.form.field.Hidden,
    xtype: 'rg-be-references-articles-ffield',

    /**
     * @cfg {Ext.tree.Panel} treeId
     * Дерево элементов.
     */
    treeId: null,

    /**
     * Форматирует имя поля.
     * @param {String} name
     * @return {String}
     */
     formatFieldName: function (name) {
        return name.trimWord('fields[').rtrimChar(']');
    },

    /**
     * Возвращает массив полей из указанного узла дерева.
     * @param {Ext.tree.Node} node
     * @return {Array}
     */
    getFields: function (node) {
        var fields = [];
    
        for (let child of node.childNodes) {
            let properties = child.data.properties || {},
                items = this.getFields(child);
            if (child.data.isField === 1 && properties.name !== null && properties.name.length > 0) {
                let name = this.formatFieldName(properties.name);
                fields.push(name);
            }
            if (items.length > 0) {
                fields = fields.concat(items);
            }
        }
        return fields;
    },

    /**
     * Возвращает значение, которое будет включено в стандартную отправку формы для 
     * этого поля. 
     */
    getSubmitValue: function () {
        let tree = Ext.getCmp(this.treeId);
        if (!Ext.isDefined(tree)) {
            return null;
        }
        // если сетка не отобразилась, значит изменений в ней нет
        if (!tree.rendered) {
            return null;
        }

        let root = tree.getRootNode(),
            fields = this.getFields(root);
        return Ext.util.JSON.encode(fields);
    }
});


/**
 * @class Rg.be.references.articles.ComponentsField
 * @extends Ext.form.field.Hidden
 * Компонент скрытого поля для получения компонентов из дерева элементов в формате JSON.
 */
Ext.define('Rg.be.references.articles.ComponentsField', {
    extend: Ext.form.field.Hidden,
    xtype: 'rg-be-references-articles-cfield',

    /**
     * @cfg {Ext.tree.Panel} treeId
     * Дерево элементов.
     */
    treeId: null,

    /**
     * Возвращает "чистые" свойства компонента
     * @param {Object} properties Свойства компонента.
     * @return {Object}
     */
    prepareProperties: (properties) => {
        let prepare = {};
        for (let property in properties) {
            let value = properties[property];
            if (value === null || value === '' || property === 'elementName') continue;
            if (property === 'xtype' && value === 'tab') continue;

            prepare[property] = properties[property];
        }
        return prepare;
    },

    /**
     * Возвращает массив компонентов из указанного узла дерева.
     * @param {Ext.tree.Node} node
     * @return {Array}
     */
    getComponents: function (node) {
        var components = [];
    
        for (let child of node.childNodes) {
            let component = this.prepareProperties(child.data.properties || {}),
                items = this.getComponents(child);
            if (items.length > 0 ) {
                component.items = items;
            }
            components.push(component);
        }
        return components;
    },

    /**
     * Возвращает значение, которое будет включено в стандартную отправку формы для 
     * этого поля. 
     */
    getSubmitValue: function () {
        let tree = Ext.getCmp(this.treeId);
        if (!Ext.isDefined(tree)) {
            return null;
        }
        // если сетка не отобразилась, значит изменений в ней нет
        if (!tree.rendered) {
            return null;
        }

        let root = tree.getRootNode(),
            cmps = this.getComponents(root);
        return Ext.util.JSON.encode(cmps);
    }
});
