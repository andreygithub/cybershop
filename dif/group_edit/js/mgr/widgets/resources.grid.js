
/**
 * Таблица ресурсов
 *
 * @class grEdit.grid.catalog
 * @extends Ext.grid
 * @param {Object} config An object of options.
 * @xtype group_edit-grid-catalog
 */

grEdit.grid.catalog = function(config) {
    config = config || {};
    this.sm = new Ext.grid.CheckboxSelectionModel();
    Ext.applyIf(config,{
        id: 'group_edit-grid-catalog-cmp'
        ,url: grEdit.config.connector_url
        ,baseParams: {action: 'mgr/getlist_resources', a: grEdit.request.a, type: grEdit.request.type, categoryId: grEdit.config.parentId, parentId: 0, template: 0}
        ,save_action: 'mgr/updatefromgrid_resource'
        ,fields: this.getGridFields()//['id','pagetitle','deleted','isfolder','parent','tv'+group_edit.config.tvId,'itemClass','menu']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '97%'
        ,sm: this.sm
        ,pageSize: 20
        ,sortInfo: {field: 'id', direction: 'DESC'}
        ,sortBy: 'id'
        ,sortDir: 'DESC'
        ,autoExpandColumn: 'id'
        ,waitMsg: _('loading')
        ,autoFill: true
        ,autoDestroy: true
        ,stateful: true
        ,columns: this.getGridColumns()
        ,tbar: [{
            text: _('group_edit.bulk_actions')
            ,menu: this.bulkActions(this)
        },'-',{
            text: ''
            ,iconCls: 'group_edit_newres'
            ,tooltip: _('group_edit.new_resource')
            ,handler: this.addItem
        },'-',{
            text: grEdit.config.modName
            ,id: 'group_edit-gotoup_level'
            ,iconCls: 'group_edit_toplevel'
            ,tooltip: _('group_edit.to_up_level')
            ,handler: this.goToUpLevel
            ,hidden: true
            //,style: 'visibility:hidden;'
        }
        
        ,'->',{
            xtype: 'textfield'
            ,id: 'group_edit-ctl-search-filter'
            ,emptyText: _('group_edit.search')
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this.getValue());
                            this.blur();
                            return true;}
                        ,scope: cmp
                    });
                },scope:this}
            }
        },{
            text: _('group_edit.find')
            ,handler: {xtype: '' ,blankValues: true}
        },'-',{
            text: ''
            ,iconCls: 'group_edit_trash'
            ,tooltip: _('empty_recycle_bin')
            ,handler: this.emptyRecycleBin
        }]
    });
    grEdit.grid.catalog.superclass.constructor.call(this,config);
};

Ext.extend(grEdit.grid.catalog,MODx.grid.Grid,{
    
    getMenu: function() {
        var m = [{
            text: _('edit')
            ,handler: this.editItem
        },{
            text: _('group_edit.edit_newwindow')
            ,handler: this.editItemNewWindow
        },'-',{
            text: _('remove')
            ,handler: this.removeItem
        },{
            text: _('undelete')
            ,handler: this.restoreItem
        },'-',{
            text: _('resource_view')
            ,handler: this.previewItem
        }];
        this.addContextMenuItem(m);
        return true;
    }
    
    //Список полей, который приходят из БД
    ,getGridFields:function(){
        var items = ['id','pagetitle','deleted','isfolder','parent','itemClass','menu','template','uri'];
        
        for(var key in grEdit.config.fields){
            items.push(key);
        };
        
        return items;
    }
    
    //Строки и колонки в таблице
    ,getGridColumns: function(){
        
        var items = [this.sm];
        
        items.push(
            {
                header: _('id')
                ,dataIndex: 'id'
                ,sortable: true
                ,width: 50
            }
        );
        
        var i = 0;
        for(var key in grEdit.config.fields){
            var is_date = key=='pub_date' || key=='publishedon';
            var editor = {
                xtype: (is_date ? 'xdatetime' : 'textfield')
                ,allowBlank: true
                ,dateFormat: MODx.config.manager_date_format
                ,timeFormat: MODx.config.manager_time_format
            };
            items.push(
                {
                    header: grEdit.config.fields[key][0]
                    ,dataIndex: key
                    ,sortable: true
                    ,renderer: this.getRenderer(i,grEdit.config.fields[key][1])//''//(is_date ? Ext.util.Format.dateRenderer('m/d/Y') : '')
                    ,xtype: 'gridcolumn'
                    ,editor: editor
                }
            );
            i++;
        }
        
        return items;
    }
    
    //Возвращает функцию для визуализации значения ячейки таблицы
    ,getRenderer: function(index,type){
        var renderer = '';
        switch(type){
            case 'image':
                renderer = this.renderItemImage;
            break;
            default:
                renderer = index==0 ? this.renderItem : '';
            break;
        }
        return renderer;
    }
    
    //Рендерер для ссылок с названиями ресурсов
    ,renderItem: function(v,md,rec){
        var fields_keys = Object.keys(grEdit.config.fields);
        var out = '<a href="#" class="'+rec.data.itemClass+'" onclick="Ext.getCmp(\'group_edit-grid-catalog-cmp\').openCategory('+rec.data.id+','+rec.data.parent+','+rec.data.isfolder+');return false;">'
            +rec.data[fields_keys[0]]
            +'</a>';
        return out;
    }
    
    //Рендерер для картинок
    ,renderItemImage: function(v,md,rec){
        var image_path = v!='' ? MODx.config.base_url+'connectors/system/phpthumb.php?w=40&h=40&src='+MODx.config.base_url+v : '';
        var out = image_path!='' ? '<img src="'+image_path+'" width="40" height="40" alt="'+v+'" title="'+v+'" />' : '';
        return out;
    }
    
    //открываем категорию
    ,openCategory: function(id,parent,isfolder){
        if(isfolder){
            this.store.baseParams.categoryId = id;
            this.store.baseParams.parentId = parent;
            this.reconfigure(this.store,this.colModel);
            this.udtateReturnButton();
            this.getBottomToolbar().doRefresh();
        }
    }
    
    //Обновление кнопки возвращения на предыдущий уровень
    ,udtateReturnButton: function(){
        var res_id = this.store.baseParams.categoryId;
        if(res_id == grEdit.config.topParentId){
            Ext.getCmp('group_edit-gotoup_level')
            .setVisible(false);
            return;
        }
        MODx.Ajax.request({
            url: grEdit.config.connector_url
            ,params: {action: 'mgr/get_parent', id: res_id}
            ,listeners: {
                'success': {fn:function(res) {
                    var resource = res.object[0];
                    var buttonText = resource.pagetitle.length<=20 ? resource.pagetitle : resource.pagetitle.substr(0,20)+'...';
                    Ext.getCmp('group_edit-gotoup_level')
                    .setVisible(true)
                    .setText(buttonText);
                },scope:this}
            }
        });
    }
    
    //Возвращение на предыдущий уровень
    ,goToUpLevel: function(){
        var categoryId = this.store.baseParams.parentId!=0 ? this.store.baseParams.parentId : grEdit.config.parentId;
        var parent = grEdit.config.parentId;
        this.store.baseParams.categoryId = categoryId;
        this.store.baseParams.parentId = parent;
        this.reconfigure(this.store,this.colModel);
        this.udtateReturnButton();
        this.getBottomToolbar().doRefresh();
    }
    
    //Переход к редактированию в новой ккладке браузера
    ,editItemNewWindow: function(){
        var res_id = this.menu.record.id;
        var newTab = window.open('/manager/?a=30&id='+res_id, '_newtab');//'_blank');
        newTab.top.opener = null;
        newTab.focus();
    }
    
    //Редактирование документа
    ,editItem: function(){
        
        if(Ext.get('modx-panel-resource'+this.menu.record.id) != null) return false;
        
        var root = this;
        Ext.get('group_edit-grid-catalog-cmp').mask(_('loading'),'x-mask-loading');
        
        var res_id = this.menu.record.id;
        
        MODx.Ajax.request({
            url: MODx.config.connectors_url+'resource/index.php'
            ,params: {
                action: 'get'
                ,id: res_id
            }
            ,listeners: {
                'success': {fn:function(res) {
                    root.loadResource(res.object, 'update');
                },scope:this}
            }
        });
        
    }
    
    //Добавление документа
    ,addItem: function(){
        
        var root = this;
        
        Ext.get('group_edit-grid-catalog-cmp').mask(_('loading'),'x-mask-loading');
        
        var categoryId = this.store.baseParams.categoryId;
        
        //берем шаблон у соседнего документа
        var itemTemplate = 0;
        var store = this.getStore();
        if(store.getCount()>0){
            itemTemplate = store.getAt(0).data.template;
        }
        
        var resource = {"id":Ext.id(null,'res'),"template":itemTemplate,"content_type":1,"class_key":"modDocument","context_key":grEdit.config.context,"parent":categoryId,"richtext":true,"hidemenu":false,"published":true,"searchable":true,"cacheable":true,"isfolder":false,"deleted":false,"uri_override":false};
        
        root.loadResource(resource, 'new');
        
    }
    
    ,loadResource: function(resource,action){
        
        var root = this;
        
        if(action == 'new'){
            var tv_post_data = {action: 'mgr/tvs', ident: resource.id, parent: resource.parent, template: resource.template};
        }else if(action == 'update'){
            var tv_post_data = {action: 'mgr/tvs', id: resource.id};
        }
        
        var itemId = resource.id;
        
        MODx.Ajax.request({
            url: grEdit.config.connector_url
            ,params: tv_post_data
            ,listeners: {
                'success': {fn:function(res) {
                    
                    var tv_values = res.object.tv_values;
                    
                    Ext.get('modx-resource-tvs-cont').insertHtml('beforeEnd', '<div id="modx-resource-tvs-div'+itemId+'"></div>');
                    
                    Ext.getCmp('group_edit-panel-home-tabs-cmp').add({
                        title: action == 'update' ? resource.pagetitle : _('new')
                        ,closable: true
                        ,listeners: {
                            afterrender: function(panel){
                                
                                var containerId = panel.id;
                                
                                if(Ext.get('modx-panel-resource'+itemId)==null){
                                    
                                    MODx.config.publish_document = "1";
                                    MODx.onDocFormRender = "";
                                    MODx.ctx = "catalog";
                                    Ext.onReady(function() {
                                        MODx.load({
                                            xtype: "modx-panel-resource"//"modx-page-resource-update"
                                            ,formpanel: 'modx-panel-resource'+itemId
                                            ,ident: itemId
                                            ,id: 'modx-panel-resource'+itemId
                                            ,panelRenderTo: containerId
                                            ,renderTo: containerId
                                            ,resource: itemId
                                            ,record: resource
                                            ,publish_document: "1"
                                            ,preview_url: ""
                                            ,locked: 0
                                            ,lockedText: ""
                                            ,canSave: 1
                                            ,canEdit: 1
                                            ,canCreate: 1
                                            ,canDuplicate: 1
                                            ,canDelete: 1
                                            ,show_tvs: 1
                                            ,mode: "update"
                                            ,stateEvents: ['afterrender']
                                            ,getState:function() {
                                                Ext.get('group_edit-grid-catalog-cmp').unmask();
                                                
                                                //Ext.get('modx-resource-tvs-div').set({id: 'modx-resource-tvs-div'+itemId});
                                                //if(Ext.get('modx-tv-tabs')!=null) Ext.get('modx-tv-tabs').set({id: 'modx-tv-tabs'+itemId});
                                                
                                                root.parseAndRunScript(res.object.data, 'modx-resource-tvs-div'+itemId);
                                                
                                                root.renderTVtabs(itemId);
                                                
                                                MODx.hideTab("modx-resource-tabs18","modx-resource-access-permissions");
                                                
                                                //root.renderTV(itemId,tv_values,resource.context_key);
                                                
                                                //RTE
                                                var content_field = Ext.query('#modx-panel-resource'+itemId+' textarea[name=ta]');
                                                var content_field_id = content_field[0].id;
                                                if(MODx.config.use_editor && resource.richtext==1 && Ext.get(content_field_id+'_ifr')==null && typeof(tinymce)!='undefined'){
                                                    //new tinymce.Editor(content_field_id, Tiny.config).render();
                                                    tinyMCE.execCommand('mceAddControl', false, content_field_id);
                                                }
                                                
                                                var els = Ext.query('.modx-richtext');
                                                Ext.each(els,function(el,i) {
                                                    el = Ext.get(el);
                                                    tinyMCE.execCommand('mceAddControl', false, el.dom.id);
                                                },this);
                                                
                                            }
                                        });
                                    });
                                    
                                    Ext.get('group_edit-grid-catalog-cmp').unmask();
                                    
                                }
                            }
                        }
                        
                    }).show();
                    
                },scope:this}
            }
        });
        
    }
    
    //просмотр ресурса
    ,previewItem: function(){
        var preview_url = MODx.config.base_url+this.menu.record.uri;
        window.open(preview_url, '_blank');
    }
    
    //удаление ресурса
    ,removeItem: function(){
        MODx.msg.confirm({
            title: _('resource_delete')
            ,text: _('resource_delete_confirm')
            ,url: MODx.config.connectors_url+'resource/index.php'
            ,params: {
                action: 'delete'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    
    //восстановление ресурса
    ,restoreItem: function() {
        MODx.Ajax.request({
            url: MODx.config.connectors_url+'resource/index.php'
            ,params: {
                action: 'undelete'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    
    //очистка корзины
    ,emptyRecycleBin: function() {
        MODx.msg.confirm({
            title: _('empty_recycle_bin')
            ,text: _('empty_recycle_bin_confirm')
            ,url: MODx.config.connectors_url+'resource/index.php'
            ,params: {
                action: 'emptyRecycleBin'
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    
    ,bulkActions: function(root){
        var tbar_menu_items = [];
        //tbar_menu_items.push('-');
        tbar_menu_items.push({text: _('group_edit.remove_selected') ,handler: root.removeSelected ,scope: this});
        return tbar_menu_items;
    }
    
    ,getSelectedAsList: function() {
        var sels = this.getSelectionModel().getSelections();
        if (sels.length <= 0) return false;
        var cs = [];
        for (var i=0;i<sels.length;i++) {
            cs.push(sels[i].id);
        }
        return cs;
    }

    ,search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }

    ,removeSelected: function(btn,e) {
        var productIds = this.getSelectedAsList();
        if (productIds === false) return false;
        Ext.MessageBox.confirm(
            _('remove_selected'),
            _('group_edit.remove_selected_confirm'),
            function(btn, text){
                if(btn=='yes'){
                    Ext.get('group_edit-grid-catalog-cmp').mask(_('loading'),'x-mask-loading');
                    Ext.each(productIds, function(item_id,index){
                        MODx.Ajax.request({
                            url: MODx.config.connectors_url+'resource/index.php'
                            ,params: {
                                action: 'delete'
                                ,id: item_id
                            }
                            ,listeners: {
                                //'success': {fn:this.refresh,scope:this}
                            }
                        });
                        MODx.sleep(500);
                    });
                    Ext.getCmp('group_edit-grid-catalog-cmp').refresh();
                    Ext.get('group_edit-grid-catalog-cmp').unmask();
                }
            }
        );
       return true;
    }
    
    
    //вкладки TV параметров
    ,renderTVtabs: function(itemId){
        
        if(Ext.get('modx-tv-tabs_'+itemId)==null) return;
        
        MODx.load({
            xtype: 'modx-vtabs'
            ,applyTo: 'modx-tv-tabs_'+itemId
            ,autoTabs: true
            ,border: false
            ,plain: true
            ,deferredRender: false
            ,id: 'modx-resource-vtabs_'+itemId
            ,headerCfg: {
                tag: 'div'
                ,cls: 'x-tab-panel-header vertical-tabs-header'
                ,id: 'modx-resource-vtabs-header'
                ,html: MODx.config.show_tv_categories_header == true ? '<h4 id="modx-resource-vtabs-header-title">'+_('categories')+'</h4>' : ''
            }
        });
        
    }
    
    
    //парсит и запускает скрипты из строки
    ,parseAndRunScript: function(source,elem){
        var scripts = new Array();
        if(source==null) return;
        // Strip out tags
        //Ext.get(elem).update(source);
        while(source.indexOf("<script") > -1 || source.indexOf("</script") > -1) {
            var s = source.indexOf("<script");
            var s_e = source.indexOf(">", s);
            var e = source.indexOf("</script", s);
            var e_e = source.indexOf(">", e);
            scripts.push(source.substring(s_e+1, e));
            source = source.substring(0, s) + source.substring(e_e+1);
        }
        Ext.get(elem).update(source);
        for(var i=0; i<scripts.length; i++) {
            try {
                eval(scripts[i]);
            }
            catch(ex) {
                //alert(scripts[i]);
            }
        }
    }
    
    
});
Ext.reg('group_edit-grid-catalog',grEdit.grid.catalog);

