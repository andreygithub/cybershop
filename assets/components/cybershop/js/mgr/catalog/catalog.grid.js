
Cybershop.grid.Catalog = function(config) {
    config = config || {};
    config.id = Ext.id();
    this.sm = new Ext.grid.CheckboxSelectionModel();
    Ext.applyIf(config,{
        id: config.id
        ,url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/catalog/getList' }
        ,save_action: 'mgr/catalog/updateFromGrid'
        ,fields: ['id','name','description','article'
                 ,'image','brand','brand_name','category'
                 ,'category_name','made_in','media'
                 ,'price1','price2','price3',
                 'value1','value2','value3','weight'
                 ,'active','deleted','new','alias'
                 ,'sellout','discount','onhomepage'
                 ,'url','ceo_data','ceo_key','ceo_description','editedon']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '99%'
        ,autoExpandColumn: 'name'
        ,viewConfig: {
            forceFit:true
            ,enableRowBody:true
            ,scrollOffset: 0
            ,autoFill: true
            ,showPreview: true
            ,getRowClass : function(rec){
                grid_row = '';
                grid_row = rec.data.active ? grid_row : 'grid-row-inactive';
                grid_row = rec.data.deleted ? 'grid-row-deleted' : grid_row;
                return grid_row;
            }
        }
        ,sm: this.sm
        ,columns: [this.sm,{
            header: _('cs_id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 60
        },{
            header: _('cs_active')
            ,dataIndex: 'active'
            ,sortable: true
            ,width: 30
            ,renderer: this.renderBoolean
            ,editor: {
                xtype: 'xcheckbox'
                        }
        },{
            header: _('cs_deleted')
            ,dataIndex: 'deleted'
            ,sortable: true
            ,width: 30
            ,renderer: this.renderBoolean
        },{
            header: _('cs_image')
            ,dataIndex: 'image'
            ,sortable: false
            ,renderer: this.renderImg
            ,width: 80
        },{
            header: _('cs_name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 200
            ,editor: new Ext.form.TextField({
                allowBlank: false
                })
        },{
            header: _('cs_description')
            ,dataIndex: 'description'
            ,sortable: false
            ,width: 200
            ,editor: new Ext.form.TextField({
                allowBlank: true
                })   
        },{
            header: _('cs_article')
            ,dataIndex: 'article'
            ,sortable: true
            ,width: 100
            ,editor: new Ext.form.TextField({
                allowBlank: true
            })            
        },{
	     header: _('cs_brand')
            ,dataIndex: 'brand_name'
            ,sortable: true
            ,width: 100
        },{
	     header: _('cs_category')
            ,dataIndex: 'category_name'
            ,sortable: true
            ,width: 100
        },{	
	     header: _('cs_price1')
            ,dataIndex: 'price1'
            ,sortable: true
            ,width: 60
            ,editor: new Ext.form.NumberField({
                decimalPrecision: 5
                ,allowBlank: true
                ,allowNegative: false
                ,maxValue: 100000
                })
        },{
	     header: 'Дата изменений'
            ,dataIndex: 'editedon'
            ,sortable: true
            ,width: 100
        }]
       ,tbar: [{ 
            text: _('bulk_actions')
            ,menu: [{
                text: 'Опубликовать выбранное'
                ,handler: this.activateSelected
                ,scope: this
            },{
                text: 'Снять с публикации выбранное'
                ,handler: this.deactivateSelected
                ,scope: this
            },'-',{
                text: 'Пометить на удаление'
                ,handler: this.removeSelected
                ,scope: this
            },{
                text: 'Снять пометку на удаление'
                ,handler: this.restoreRemoveSelected
                ,scope: this
            },'-',{
                text: 'Удалить пемеченные на удаление'
                ,handler: this.removeFromBase
                ,scope: this
            }]
       },{
            text: _('cs_element_create')
            ,handler: { 
                xtype: 'cybershop-window-catalog' 
                ,blankValues: true 
                ,title: _('cs_element_create')
                ,baseParams: {
                    action: 'mgr/catalog/create'
                }
            }
        },{
             text: _('cs_export')
            ,handler:  {
                xtype: 'cybershop-window-catalog_export' 
                }
        },{
            text: _('cs_import')
            ,handler: {
                xtype: 'cybershop-window-catalog_import' 
                }
        },'->',{
            xtype: 'modx-combo'
            ,id: config.id+'-combo-brands'
            ,name: 'brands'
            ,itemId: 'brands'
            ,emptyText: _('cs_selectElement')+'...'
            ,url: Cybershop.config.connectorUrl
            ,baseParams: {
                action: 'mgr/brands/getList'
                ,combo: true
                ,addall: true
            }
   //         ,value: MODx.request['usergroup'] ? MODx.request['usergroup'] : ''
            ,width: 200
            ,listeners: {
                'select': {fn:this.filterBrands,scope:this}
            }
        },'-',{
            xtype: 'modx-combo'
            ,id: config.id+'-combo-categorys'
            ,name: 'categorys'
            ,itemId: 'categorys'
            ,emptyText: _('cs_selectElement')+'...'
            ,url: Cybershop.config.connectorUrl
            ,baseParams: {
                action: 'mgr/categorys/getList'
                ,combo: true
                ,addall: true
            }
  //          ,value: MODx.request['usergroup'] ? MODx.request['usergroup'] : ''
            ,width: 200
            ,listWidth: 500
            ,pageSize: 50
            ,listeners: {
                'select': {fn:this.filterCategorys,scope:this}
            }
        },'-',{
            xtype: 'textfield'
            ,id: config.id+'-search-filter'
            ,emptyText: _('cs_search...')
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                },scope:this}
            }
         },{
            xtype: 'button'
            ,id: config.id+'-filter-clear'
            ,text: _('filter_clear')
            ,listeners: {
                'click': {fn: this.clearFilter, scope: this}
            }
        }]
    });
    Cybershop.grid.Catalog.superclass.constructor.call(this,config)
};
Ext.extend(Cybershop.grid.Catalog,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,filterBrands: function(cb,nv,ov) {
        this.getStore().baseParams.brand = Ext.isEmpty(nv) || Ext.isObject(nv) ? cb.getValue() : nv;
        this.getBottomToolbar().changePage(1);
        this.refresh();
        return true;
    }
    ,filterCategorys: function(cb,nv,ov) {
        this.getStore().baseParams.category = Ext.isEmpty(nv) || Ext.isObject(nv) ? cb.getValue() : nv;
        this.getBottomToolbar().changePage(1);
        this.refresh();
        return true;
    }
    ,clearFilter: function() {
    	this.getStore().baseParams = {
            action: 'mgr/catalog/getList'
    	};
        Ext.getCmp(this.config.id+'-search-filter').reset();
        Ext.getCmp(this.config.id+'-combo-categorys').reset();
        Ext.getCmp(this.config.id+'-combo-brands').reset();
    	this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,getMenu: function() {
        return [{
             text: _('cs_element_create')
            ,handler: { 
                xtype: 'cybershop-window-catalog' 
                ,blankValues: true 
                ,title: _('cs_element_create')
                ,baseParams: {
                    action: 'mgr/catalog/create'
                }
            }
        },{
            text: _('cs_element_open')
            ,handler: this.updateElement
        },{
            text: _('cs_element_remove')
            ,handler: this.removeElement
        }];
    }
    ,updateElement: function(btn,e,row) {
        if (typeof(row) != 'undefined') {this.menu.record = row.data;}
        var id = this.menu.record.id;

        MODx.Ajax.request({
                url: Cybershop.config.connectorUrl
                ,params: {
                        action: 'mgr/catalog/get'
                        ,id: id
                }
                ,listeners: {
                        'success': {fn:function(r) {
                                if (!this.updateCatalogWindow) {
                                    this.updateCatalogWindow = MODx.load({
                                        xtype: 'cybershop-window-catalog'
                                        ,title: _('cs_element_update')
                                        ,record: r.object
                                        ,listeners: {
                                            'success': {fn:this.refresh,scope:this}
                                        }
                                    });
                                }
                                this.updateCatalogWindow.reset();
                                this.updateCatalogWindow.setValues(r.object);
                                this.updateCatalogWindow.show(e.target);
                        },scope:this}
                }
        });
    }
    ,removeElement: function() {
        MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/catalog/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    
    ,activateSelected: function() {
        var cs = this.getSelectedAsList();
        if (cs === false) return false;

        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/catalog/activateselected'
                ,id: cs
            }
            ,listeners: {
                'success': {fn:function(r) {
                    this.getSelectionModel().clearSelections(true);
                    this.refresh();
                },scope:this}
            }
        });
        return true;
    }
    ,deactivateSelected: function() {
        var cs = this.getSelectedAsList();
        if (cs === false) return false;

        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/catalog/deactivateselected'
                ,id: cs
            }
            ,listeners: {
                'success': {fn:function(r) {
                    this.getSelectionModel().clearSelections(true);
                    this.refresh();
                },scope:this}
            }
        });
        return true;
    }
    ,removeSelected: function() {
        var cs = this.getSelectedAsList();
        if (cs === false) return false;

        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/catalog/removeselected'
                ,id: cs
            }
            ,listeners: {
                'success': {fn:function(r) {
                    this.getSelectionModel().clearSelections(true);
                    this.refresh();
                },scope:this}
            }
        });
        return true;
    }
    ,restoreRemoveSelected: function() {
        var cs = this.getSelectedAsList();
        if (cs === false) return false;

        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/catalog/restoreremoveselected'
                ,id: cs
            }
            ,listeners: {
                'success': {fn:function(r) {
                    this.getSelectionModel().clearSelections(true);
                    this.refresh();
                },scope:this}
            }
        });
        return true;
    }
    ,removeFromBase: function() {
        MODx.msg.confirm({
            title: 'Внимание'
            ,text: 'Данные будут безвозвратно утерены, продолжить?'
            ,url: this.config.url
            ,params: {
                action: 'mgr/catalog/removefrombase'
            }
            ,listeners: {
                'success': {fn:function(r) {
                    this.getSelectionModel().clearSelections(true);
                    this.refresh();
                },scope:this}
            }
        });
        return true;
    }

    ,renderImg: function(v,md,rec) {
        var image_path = v!='' ? MODx.config.base_url+'connectors/system/phpthumb.php?w=80&src='+MODx.config.base_url+v : '';
        var out = image_path!='' ? '<img src="'+image_path+'" width="80" alt="'+v+'" title="'+v+'" />' : '';
        return out;
   }
    ,renderBoolean: function(value) {
        if (value == 1) {return _('yes');}
        else {return _('no');}
    }
});
Ext.reg('cybershop-grid-catalog',Cybershop.grid.Catalog);

