Cybershop.grid.FilterTable = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/catalog/catalogfiltertable/getList'}
        ,save_action: 'mgr/catalog/catalogfiltertable/updateFromGrid' 
        ,fields: ['id','name','filteritem_id','filteritem_name','catalog_id','catalog_catalog']
        ,grouping: false
        ,groupBy: 'name'
        ,paging: true
        ,pageSize: 5
        ,clicksToEdit: 1
        ,autosave: true
        ,remoteSort: true
        ,anchor: '100%'
        ,autoExpandColumn: 'name'
        ,columns: 
        [{
            header: _('cs_filter')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 100  
        },{
            header: _('cs_name')
            ,dataIndex: 'filteritem_name'
            ,sortable: true
 //           ,editor: this.editorCombobox
 //           ,render: this.renderCombobox
            ,width: 100 

        }]
        ,listeners: {
                    beforeedit : function(e) {
//                            alert ('selected!!!');
//                        this.setValue(data.id);
//                        this.fireEvent('select',data);
                        }
                    ,scope:this
                    }
    });

    Cybershop.grid.FilterTable.superclass.constructor.call(this,config);

};

Ext.extend(Cybershop.grid.FilterTable,MODx.grid.Grid,{
        setFilter: function() {
            this.getStore().baseParams.catalog = this.config.filterCatalog;
            this.getStore().baseParams.brand = this.config.filterBrand;
            this.getStore().baseParams.category = this.config.filterCategory;
            this.getBottomToolbar().changePage(1);
            this.refresh();
            return true;
        }
        ,getMenu: function() {
            return [{
                text: _('cs_element_update')
                ,handler: this.updateElement
            },{
                text: _('cs_element_remove')
                ,handler: this.removeElement
            }];
        }
        ,updateElement: function(btn,e) {
            if (!this.updateWindow) {
                this.updateWindow = MODx.load({
                    xtype: 'cybershop-window-filtertable-element'
                    ,title: _('cs_element_update')
                    ,record: this.menu.record
                    ,baseParams: {
                        action: 'mgr/catalog/catalogfiltertable/update'
                    }
                    ,listeners: {
                        'success': {fn:this.refresh,scope:this}
                    }
                });
            }
            this.updateWindow.setValues(this.menu.record);
//            this.updateWindow.config.filter = this.menu.record.id;
            this.updateWindow.fields[0].baseParams.filter = this.menu.record.id;
            this.updateWindow.title = this.menu.record.name;
            this.updateWindow.show(e.target);
            this.updateWindow.fp.getForm().items.itemAt(0).setValue(this.menu.record.filteritem_id);
            this.updateWindow.fp.getForm().items.itemAt(1).setValue(this.config.filterCatalog);
            this.updateWindow.fp.getForm().items.itemAt(2).setValue(this.menu.record.catalog_id);

        }
        ,removeElement: function() {
            MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/catalog/catalogfiltertable/remove'
                ,id: this.menu.record.catalog_id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
            });
        }
        ,editorCombobox: function(v,md,rec) {
            alert ('hello!!!');
        }
  /*                          xtype: 'modx-combo'
                ,fieldLabel: _('cs_filter')
//                ,name: 'id'
//                ,hiddenName: 'id'
                ,displayField: 'filteritem_name'
                ,valueField: 'filteritem_id'
                ,emptyText: _('cs_selectElement')+'...'
                ,url: Cybershop.config.connectorUrl
                ,baseParams: {
                    action: 'mgr/filter/filteritem/getList'
                    ,combo: true
                    ,addAll: true
                }
                ,pageSize: 20
                ,anchor: '99%'
                ,listeners: {
                    beforequery: function(qe){
                        delete qe.combo.lastQuery;
//                        qe.combo.baseParams.filter = this.store.;
                    }
                    ,beforeedit : function(e) {
                            alert ('selected!!!');
//                        this.setValue(data.id);
//                        this.fireEvent('select',data);
                        }
                    ,scope:this
                    }
*/
       
});
Ext.reg('cybershop-grid-filtertable',Cybershop.grid.FilterTable);

Cybershop.window.FilterTableElement = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('cs_element_update')
        ,url: Cybershop.config.connectorUrl
        ,baseParams: {
            action: 'mgr/catalog/catalogfiltertable/update'
        }
        ,width: 700  
        ,minWidth:700
        ,fields:
            [{
                xtype: 'modx-combo'
                ,fieldLabel: _('cs_filter')
                ,name: 'filteritem'
                ,hiddenName: 'filteritem'
                ,emptyText: _('cs_selectElement')+'...'
                ,url: Cybershop.config.connectorUrl
                ,baseParams: {
                    action: 'mgr/filter/filteritem/getList'
                    ,combo: true
                    ,addAll: true
                    ,filter: config.filter
                }
                ,pageSize: 20
                ,anchor: '99%'
                ,listeners: {
                    beforequery: function(qe){delete qe.combo.lastQuery;}
                    }
               },{
                xtype: 'hidden'
                ,name: 'catalog'
            },{
                xtype: 'hidden'
                ,name: 'id'
                
            }]
    });
    Cybershop.window.FilterTableElement.superclass.constructor.call(this,config);

};
Ext.extend(Cybershop.window.FilterTableElement,MODx.Window);
Ext.reg('cybershop-window-filtertable-element',Cybershop.window.FilterTableElement);
