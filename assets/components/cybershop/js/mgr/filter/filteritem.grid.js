Cybershop.grid.FilterItem = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/filter/filteritem/getList'}
        ,save_action: 'mgr/filter/filteritem/updateFromGrid' 
        ,fields: ['id','name','filter']
        ,paging: true
        ,pageSize: 5
        ,autosave: true
        ,remoteSort: true
        ,anchor: '100%'
        ,autoExpandColumn: 'name'
        ,columns: [{
            header: _('cs_name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 100    
            ,editor: 
              {
                xtype: 'textfield',
                allowBlank: false
              }
        }]

	,tbar: 
            [{
                text: _('cs_element_create')
                ,handler: this.createNewElement
            }]

       
     });
    Cybershop.grid.FilterItem.superclass.constructor.call(this,config);

};

Ext.extend(Cybershop.grid.FilterItem,MODx.grid.Grid,{
        setFilter: function() {
            this.getStore().baseParams.filter = this.config.filterId;
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
        if (!this.updateFilterElementWindow) {
            this.updateFilterElementWindow = MODx.load({
                xtype: 'cybershop-window-filteritem-create-element'
                ,title: _('cs_element_update')
                ,baseParams: {action: 'mgr/filter/filteritem/update'}
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateFilterElementWindow.setValues(this.menu.record);
        this.updateFilterElementWindow.show(e.target);
    }
        ,removeElement: function() {
            MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/filter/filteritem/remove'
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
//                        this.addListener('success',function(response){
//                            alert(response.a);
//                        },this);
                        parentCmp.savenew();
//                        this.createNewElementWindow();
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
                        xtype: 'cybershop-window-filteritem-create-element'
                        ,listeners: {
                            'success': {fn:this.refresh,scope:this}
                            }
                    });
            };
            this.createElementFilterWindow.config.blankValues = true;
            this.createElementFilterWindow.config.winid = this.config.id;
            this.createElementFilterWindow.show(); 
            this.createElementFilterWindow.fp.getForm().items.itemAt(0).setValue(this.config.filterId);
                  
        }
});
Ext.reg('cybershop-grid-filteritem',Cybershop.grid.FilterItem);

Cybershop.window.FilterItemCreateElement = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('cs_element_create')
        ,url: Cybershop.config.connectorUrl
        ,baseParams: {
            action: 'mgr/filter/filteritem/create'
        }
        ,width: 700  
        ,minWidth:700
        ,fields:
            [{
                xtype: 'hidden'
                ,name: 'filter'
            },{
                xtype: 'hidden'
                ,name: 'id'
            },{
                xtype: 'textfield'
                ,fieldLabel: _('cs_name')
                ,name: 'name'
                ,anchor: '99%'
            },{
                xtype: 'textfield'
                ,fieldLabel: _('cs_description')
                ,name: 'description'
                ,anchor: '99%'
            },{
                xtype: 'modx-combo-browser'
                ,fieldLabel: _('cs_image')
                ,name: 'image'
                ,anchor: '99%'
            }]
    });
    Cybershop.window.FilterItemCreateElement.superclass.constructor.call(this,config);

};
Ext.extend(Cybershop.window.FilterItemCreateElement,MODx.Window);
Ext.reg('cybershop-window-filteritem-create-element',Cybershop.window.FilterItemCreateElement);
