Cybershop.grid.Status = function(config) {
    config = config || {};
    config.id = Ext.id();
    Ext.applyIf(config,{
        id: config.id
        ,url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/status/getList' }
        ,save_action: 'mgr/status/updateFromGrid'
        ,fields: ['id','name','description','color','email_user','email_manager'
                 ,'subject_user','subject_manager','body_user'
                 ,'body_manager','active','final','fixed','rank','editable']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '99%'
        ,autoExpandColumn: 'name'
        ,selectOnFocus: true
        ,columns: [{
             header: _('cs_id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 50
        },{
            header: _('cs_name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 100
            ,editor: {xtype: 'textfield', allowBlank: false}
        },{
            header: _('cs_color')
            ,dataIndex: 'color'
            ,sortable: false
            ,width: 50
            ,renderer: this.renderColor
        },{
            header: _('cs_email_user')
            ,dataIndex: 'email_user'
            ,width: 50
            ,renderer: this.renderBoolean
        },{
            header: _('cs_email_manager')
            ,dataIndex: 'email_manager'
            ,width: 50
            ,renderer: this.renderBoolean
        },{
            header: _('cs_active')
            ,dataIndex: 'active'
            ,sortable: true
            ,width: 50
            ,editor: {xtype: 'combo-boolean', renderer: 'boolean'}
        },{
            header: _('cs_status_final')
            ,dataIndex: 'final'
            ,width: 50
            ,editor: {xtype: 'combo-boolean', renderer: 'boolean'}
        },{
            header: _('cs_status_fixed')
            ,dataIndex: 'fixed'
            ,width: 50
            ,editor: {xtype: 'combo-boolean', renderer: 'boolean'}
        }]
	,tbar: [{
            text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-status' 
                        ,title: _('cs_element_create')
                        ,baseParams: {action: 'mgr/status/create'}
                        ,blankValues: true }
        
        }]
        ,listeners: {
                rowDblClick: function(grid, rowIndex, e) {
                        var row = grid.store.getAt(rowIndex);
                        this.updateElement(grid, e, row);
                }
            }
    });
    Cybershop.grid.Status.superclass.constructor.call(this,config)
};
Ext.extend(Cybershop.grid.Status,MODx.grid.Grid,{
    getMenu: function() {
        return [{
	     text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-status' 
                        ,title: _('cs_element_create')
                        ,baseParams: {action: 'mgr/status/create'}
                        ,blankValues: true }
        },{
            text: _('cs_element_update')
            ,handler: this.updateElement
        },{
            text: _('cs_element_remove')
            ,handler: this.removeElement
        }];
    }
    ,updateElement: function(btn,e,row) {
        
        if (typeof(row) != 'undefined') {this.menu.record = row.data;}
        
        if (!this.updateStatusWindow) {
            this.updateStatusWindow = MODx.load({
                xtype: 'cybershop-window-status'
                ,title: _('cs_element_update')
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateStatusWindow.setValues(this.menu.record);
        this.updateStatusWindow.show(e.target);
    }

    ,removeElement: function() {
        MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/status/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    ,renderImg: function(v,md,rec) {
        var image_path = v!='' ? MODx.config.base_url+'connectors/system/phpthumb.php?w=40&h=40&src='+MODx.config.base_url+v : '';
        var out = image_path!='' ? '<img src="'+image_path+'" width="40" height="40" alt="'+v+'" title="'+v+'" />' : '';
        return out;
    }
    ,renderColor: function(value) {
            return '<div style="width: 30px; height: 20px; border-radius: 3px; background: #' + value + '">&nbsp;</div>';
    }
    ,renderBoolean: function(value) {
            if (value == 1) {return _('yes');}
            else {return _('no');}
    }
});
Ext.reg('cybershop-grid-status',Cybershop.grid.Status);