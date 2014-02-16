Cybershop.grid.Property = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'cybershop-grid-property'
        ,url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/property/getList'}
        ,save_action: 'mgr/property/updateFromGrid' 
        ,fields: ['id','name','shortname','description','xtype','active'
                 ,'image','introtext','fulltext'
                 ,'ceo_data','ceo_key','ceo_description']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '100%'
        ,autoExpandColumn: 'name'
        ,columns: [{
            header: _('cs_id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 60
        },{
            header: _('cs_name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 100
        },{
            header: _('cs_description')
            ,dataIndex: 'description'
            ,sortable: false
            ,width: 350
        }]

	,tbar: [{
            text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-property' 
                ,title: _('cs_element_create')
                ,blankValues: true
                ,baseParams: {action: 'mgr/property/create'}
            }
        }]

       
     });
    Cybershop.grid.Property.superclass.constructor.call(this,config)
};

Ext.extend(Cybershop.grid.Property,MODx.grid.Grid,{
    getMenu: function() {
        return [{
	     text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-property' 
                        ,blankValues: true
                        ,title: _('cs_element_create')
                      }
        },{
            text: _('cs_element_update')
            ,handler: this.updateElement
        },{
            text: _('cs_element_remove')
            ,handler: this.removeElement
        }];
    }
    ,updateElement: function(btn,e) {
        if (!this.updatePropertyWindow) {
            this.updatePropertyWindow = MODx.load({
                xtype: 'cybershop-window-property'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updatePropertyWindow.setValues(this.menu.record);
        this.updatePropertyWindow.show(e.target);
    }

    ,removeElement: function() {
        MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/property/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});
Ext.reg('cybershop-grid-property',Cybershop.grid.Property);

