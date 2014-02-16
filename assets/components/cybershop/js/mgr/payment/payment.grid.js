Cybershop.grid.Payment = function(config) {
    config = config || {};
    config.id = Ext.id()
    Ext.applyIf(config,{
        id: config.id
        ,url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/payment/getList' }
        ,save_action: 'mgr/payment/updateFromGrid'
        ,fields: ['id','name','description','image','rank','active','class']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '99%'
        ,autoExpandColumn: 'name'
        ,sm: this.sm
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
            header: _('cs_image')
            ,dataIndex: 'image'
            ,sortable: false
            ,width: 75
            ,renderer: this.renderImg
        },{
            header: _('cs_active')
            ,dataIndex: 'active'
            ,sortable: true
            ,width: 50
            ,editor: {xtype: 'combo-boolean', renderer: 'boolean'}
        },{
            header: _('cs_class')
            ,dataIndex: 'class'
            ,sortable: true
            ,width: 75
            ,editor: {xtype: 'textfield'}
        }]
	,tbar: [{
            text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-payment' 
                        ,title: _('cs_element_create')
                        ,baseParams: {action: 'mgr/payment/create'}
                        ,blankValues: true }
        }]
        ,listeners: {
                rowDblClick: function(grid, rowIndex, e) {
                        var row = grid.store.getAt(rowIndex);
                        this.updateElement(grid, e, row);
                }
            }
    });
    Cybershop.grid.Payment.superclass.constructor.call(this,config)
};
Ext.extend(Cybershop.grid.Payment,MODx.grid.Grid,{
    getMenu: function() {
        return [{
	     text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-payment' 
                        ,title: _('cs_element_create')
                        ,baseParams: {action: 'mgr/payment/create'}
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
        
        if (!this.updatePaymentWindow) {
            this.updatePaymentWindow = MODx.load({
                xtype: 'cybershop-window-payment'
                ,title: _('cs_element_update')
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updatePaymentWindow.setValues(this.menu.record);
        this.updatePaymentWindow.show(e.target);
    }

    ,removeElement: function() {
        MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/payment/remove'
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
});
Ext.reg('cybershop-grid-payment',Cybershop.grid.Payment);

