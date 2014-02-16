Cybershop.grid.Orders = function(config) {
    config = config || {};
    config.id = Ext.id()
    Ext.applyIf(config,{
        id: config.id
        ,url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/orders/getList' }
        ,save_action: 'mgr/orders/updateFromGrid'
        ,fields: ['id','user_id','customer','num','status','delivery','payment'
                 ,'cost','weight','createdon','updatedon','comment','context']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '99%'
        ,autoExpandColumn: 'name'
        ,sm: this.sm
        ,selectOnFocus: true
        ,columns: 
        [{
            header: _('cs_id')
            ,dataIndex: 'id'
            ,width: 50
            ,sortable: true
        },{
            header: _('cs_customer')
            ,dataIndex: 'customer'
            ,width: 150
            ,sortable: true
            ,renderer: this.userLink
        },{
            header: _('cs_num')
            ,dataIndex: 'num'
            ,width: 50
            ,sortable: true
        },{
            header: _('cs_status')
            ,dataIndex: 'status'
            ,width: 50
            ,sortable: true
        },{
            header: _('cs_cost')
            ,dataIndex: 'cost'
            ,width: 50
            ,sortable: true
        },{
            header: _('cs_weight')
            ,dataIndex: 'weight'
            ,width: 50
            ,sortable: true
        },{
            header: _('cs_delivery')
            ,dataIndex: 'delivery'
            ,width: 100
            ,sortable: true
        },{
            header: _('cs_payment')
            ,dataIndex: 'payment'
            ,width: 100
            ,sortable: true
        },{
            header: _('cs_createdon')
            ,dataIndex: 'createdon'
            ,width: 75
            ,sortable: true
        },{
            header: _('cs_updatedon')
            ,dataIndex: 'updatedon'
            ,width: 75, sortable: true
        }]
	,tbar: [{
                xtype: 'cybershop-combo-status'
                ,id: 'tbar-cybershop-combo-status'
                ,width: 200
                ,addall: true
                ,listeners: {
                        select: {fn: this.filterByStatus, scope:this}
                }
        },'->',{
                xtype: 'textfield'
                ,name: 'query'
                ,width: 200
                ,id: 'cybershop-orders-search'
                ,emptyText: _('cs_search...')
                ,listeners: {
                        render: {fn:function(tf) {tf.getEl().addKeyListener(Ext.EventObject.ENTER,function() {this.FilterByQuery(tf);},this);},scope:this}
                }
        },{
                xtype: 'button'
                ,id: 'cybershop-orders-clear'
                ,text: _('filter_clear')
                ,listeners: {
                        click: {fn: this.clearFilter, scope: this}
                }

        }]
        ,listeners: {
                rowDblClick: function(grid, rowIndex, e) {
                        var row = grid.store.getAt(rowIndex);
                        this.updateElement(grid, e, row);
                }
            }
    });
    Cybershop.grid.Orders.superclass.constructor.call(this,config)
};
Ext.extend(Cybershop.grid.Orders,MODx.grid.Grid,{
    getMenu: function() {
        return [{
            text: _('cs_element_open')
            ,handler: this.updateElement
        },{
            text: _('cs_element_remove')
            ,handler: this.removeElement
        }];
    }
    ,FilterByQuery: function(tf, nv, ov) {
            var s = this.getStore();
            s.baseParams.query = tf.getValue();
            this.getBottomToolbar().changePage(1);
            this.refresh();
    }

    ,clearFilter: function(btn,e) {
            var s = this.getStore();
            s.baseParams.query = '';
            Ext.getCmp('cybershop-orders-search').setValue('');
            this.getBottomToolbar().changePage(1);
            this.refresh();
    }

    ,filterByStatus: function(cb) {
            this.getStore().baseParams['status'] = cb.value;
            this.getBottomToolbar().changePage(1);
            this.refresh();
    }
    ,updateElement: function(btn,e,row) {
        
        if (typeof(row) != 'undefined') {this.menu.record = row.data;}
        
        MODx.Ajax.request({
                url: Cybershop.config.connectorUrl
                ,params: {
                        action: 'mgr/orders/get'
                        ,id: this.menu.record.id
                }
                ,listeners: {
                        'success': {fn:function(r) {
                            if (!this.updateOrdersWindow) {
                                this.updateOrdersWindow = MODx.load({
                                    xtype: 'cybershop-window-order'
                                    ,title: _('cs_element_update')
                                    ,record: r.object
                                    ,listeners: {
                                        'success': {fn:this.refresh,scope:this}
                                    }
                                });
                            }
                            this.updateOrdersWindow.reset();
                            this.updateOrdersWindow.setValues(r.object);
                            this.updateOrdersWindow.show(e.target);
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
                action: 'mgr/orders/remove'
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
    ,userLink: function(val,cell,row) {
	if (!val) {return '';}
	var action = MODx.action ? MODx.action['security/user/update'] : 'security/user/update';
	var url = 'index.php?a='+action+'&id='+row.data['user_id'];

	return '<a href="' + url + '" target="_blank" class="cs-link">' + val + '</a>'
    }
});
Ext.reg('cybershop-grid-orders',Cybershop.grid.Orders);

