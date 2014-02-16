Cybershop.grid.Filter = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'cybershop-grid-filter'
        ,url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/filter/getList'}
        ,save_action: 'mgr/filter/updateFromGrid' 
        ,fields: ['id','name','description','image','introtext','fulltext'
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
            ,handler: { xtype: 'cybershop-window-filter' 
                ,title: _('cs_element_create')
                ,blankValues: true
                ,baseParams: {action: 'mgr/filter/create'}
            }
        }]

       
     });
    Cybershop.grid.Filter.superclass.constructor.call(this,config)
};

Ext.extend(Cybershop.grid.Filter,MODx.grid.Grid,{
    getMenu: function() {
        return [{
	     text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-filter' 
                        ,blankValues: true
                        ,title: _('cs_element_create')
                        ,baseParams: {action: 'mgr/filter/create'}
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
        if (!this.updateFilterWindow) {
            this.updateFilterWindow = MODx.load({
                xtype: 'cybershop-window-filter'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateFilterWindow.setTableFilter(this.menu.record.id);
        this.updateFilterWindow.setValues(this.menu.record);
        this.updateFilterWindow.show(e.target);
    }

    ,removeElement: function() {
        MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/filter/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});
Ext.reg('cybershop-grid-filter',Cybershop.grid.Filter);

