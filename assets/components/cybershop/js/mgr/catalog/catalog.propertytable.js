Cybershop.grid.PropertyTable = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/catalog/catalogpropertytable/getList'}
        ,save_action: 'mgr/catalog/catalogpropertytable/updateFromGrid' 
        ,fields: ['id','name','xtype','property_id','property_value','catalog_id']
        ,grouping: false
        ,groupBy: 'name'
        ,paging: true
        ,pageSize: 5
        ,clicksToEdit: 1
        ,autosave: true
        ,remoteSort: true
        ,anchor: '100%'
        ,autoExpandColumn: 'property_value'
        ,columns: 
        [{
            header: _('cs_property')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 200  
        },{
            header: _('cs_value')
            ,dataIndex: 'property_value'
            ,sortable: true
            ,editable: true
            ,editor: { xtype: 'textfield' ,allowBlank: true }
            ,width: 400   
        }]

    });

    Cybershop.grid.PropertyTable.superclass.constructor.call(this,config);

};

Ext.extend(Cybershop.grid.PropertyTable,MODx.grid.Grid,{
        setFilter: function() {
            this.getStore().baseParams.catalog = this.config.filterCatalog;
            this.getBottomToolbar().changePage(1);
            this.refresh();
            return true;
        }
        ,getMenu: function() {
            return [{
                text: _('cs_element_remove')
                ,handler: this.removeElement
            }];
        }
        ,removeElement: function() {
            MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/catalog/catalogpropertytable/remove'
                ,id: this.menu.record.catalog_id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
            });
        }
});
Ext.reg('cybershop-grid-propertytable',Cybershop.grid.PropertyTable);
