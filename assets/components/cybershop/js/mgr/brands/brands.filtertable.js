Cybershop.grid.FilterTable = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/brands/brandsfiltertable/getList'}
        ,save_action: 'mgr/brands.filtertable/updateFromGrid' 
        ,fields: ['id','brand','filter','filter_name']
        ,paging: true
        ,pageSize: 5
        ,autosave: true
        ,remoteSort: true
        ,anchor: '100%'
        ,autoExpandColumn: 'filter_name'
        ,columns: [{
            header: _('cs_name')
            ,dataIndex: 'filter_name'
            ,sortable: true
            ,width: 100    
         }]

	,tbar: 
            [{
                text: _('cs_element_create')
                ,handler: this.createNewElement
            }]

       
     });
    Cybershop.grid.FilterTable.superclass.constructor.call(this,config);

};

Ext.extend(Cybershop.grid.FilterTable,MODx.grid.Grid,{
        setFilter: function() {
            this.getStore().baseParams.brand = this.config.filterId;
            this.getBottomToolbar().changePage(1);
            this.refresh();
            return true;
        }
        ,getMenu: function() {
            return [{
                 text: _('cs_element_create')
                ,handler: this.createNewElement
            },{
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
                        action: 'mgr/brands/brandsfiltertable/update'
                    }
                    ,listeners: {
                        'success': {fn:this.refresh,scope:this}
                    }
                });
            }
            this.updateWindow.setValues(this.menu.record);
            this.updateWindow.show(e.target);
            this.updateWindow.fp.getForm().items.itemAt(1).setValue(this.config.filterId);
        }
        ,removeElement: function() {
            MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/brands/brandsfiltertable/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
            });
        }
        ,createNewElement: function() {
            parentCmp = Ext.getCmp(this.config.winid);

            if (parentCmp.blankValues){

                Ext.Msg.confirm(_('cs_element_save'),_('cs_element_save_confirm'),function(e) {
                    if (e == 'yes') {
                        parentCmp.savenew();
                        return;
                        }
                    else {
                        return;
                    }
                },this);
            }
            else{
                this.createNewElementWindow();
                return;
            }
        }
        ,createNewElementWindow: function() {
            if (!this.createElementFilterWindow) {
                this.createElementFilterWindow = new MODx.load({
                        xtype: 'cybershop-window-filtertable-element'
                        ,title: _('cs_element_create')
                        ,listeners: {
                            'success': {fn:this.refresh,scope:this}
                            }
                    });
            };
            this.createElementFilterWindow.config.blankValues = true;
            this.createElementFilterWindow.config.winid = this.config.id;
            this.createElementFilterWindow.show(); 
            this.createElementFilterWindow.fp.getForm().items.itemAt(1).setValue(this.config.filterId);
                  
        }
});
Ext.reg('cybershop-grid-filtertable',Cybershop.grid.FilterTable);

Cybershop.window.FilterTableElement = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('cs_element_create')
        ,url: Cybershop.config.connectorUrl
        ,baseParams: {
            action: 'mgr/brands/brandsfiltertable/create'
        }
        ,width: 700  
        ,minWidth:700
        ,fields:
            [{
                xtype: 'modx-combo'
                ,fieldLabel: _('cs_filter')
                ,name: 'filter'
                ,hiddenName: 'filter'
                ,emptyText: _('cs_selectElement')+'...'
                ,url: Cybershop.config.connectorUrl
                ,baseParams: {
                    action: 'mgr/filter/getList'
                    ,combo: true
                    ,addAll: true
                }
                ,pageSize: 20
                ,anchor: '100%'
            },{
                xtype: 'hidden'//'hidden'
                ,name: 'brand'
            },{
                xtype: 'hidden'
                ,name: 'id'
            }]
    });
    Cybershop.window.FilterTableElement.superclass.constructor.call(this,config);

};
Ext.extend(Cybershop.window.FilterTableElement,MODx.Window);
Ext.reg('cybershop-window-filtertable-element',Cybershop.window.FilterTableElement);
