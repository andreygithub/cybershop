Cybershop.window.UpdateOrder = function(config) {
	config = config || {};
        config.id = Ext.id();
	Ext.applyIf(config,{
		title: _('cs_element_update')
		,id: config.id
		,width: 750
		,labelAlign: 'top'
		,url: Cybershop.config.connectorUrl
		,action: 'mgr/orders/update'
		,fields: {
			xtype: 'modx-tabs'
			//,border: true
//			,activeTab: config.activeTab || 0
			,bodyStyle: { background: 'transparent'}
			,deferredRender: false
			,autoHeight: true
			,stateful: true
			,stateId: 'cybershop-window-order-update'
			,stateEvents: ['tabchange']
			,getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};}
			,items: [{
				title: _('cs_order')
				,hideMode: 'offsets'
				,bodyStyle: 'padding:5px 0;'
				,defaults: {msgTarget: 'under',border: false}
				,items: this.getOrderFields(config)
			},{
				xtype: 'cybershop-grid-order-products'
				,title: _('cs_order_products')
                                ,id: config.id+'-grid-order-products'
                                ,paging: true
                                ,pageSize: 5
			},{
				layout: 'form'
				,title: _('cs_address')
				,hideMode: 'offsets'
				,bodyStyle: 'padding:5px 0;'
				,defaults: {msgTarget: 'under',border: false}
				,items: this.getAddressFields(config)
			},{
				xtype: 'cybershop-grid-order-logs'
				,title: _('cs_order_log')
				,id: config.id+'-grid-order-logs'
                                ,paging: true
                                ,pageSize: 5
			}]

		}
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	Cybershop.window.UpdateOrder.superclass.constructor.call(this,config);
        this.on('show',function() {
            filtervalue = this.fp.getForm().items.itemAt(0).getValue();
            Ext.getCmp(this.config.id+'-grid-order-products').config.filterId = filtervalue;
            Ext.getCmp(this.config.id+'-grid-order-logs').config.filterId = filtervalue;
            Ext.getCmp(this.config.id+'-grid-order-products').setFilter();
            Ext.getCmp(this.config.id+'-grid-order-logs').setFilter();
        });

};
Ext.extend(Cybershop.window.UpdateOrder,MODx.Window, {

	getOrderFields: function(config) {
		return [{
				xtype: 'hidden'
				,name: 'id'
			},{
				layout: 'column'
				,defaults: {msgTarget: 'under',border: false}
				,style: 'padding:15px 5px;text-align:left;'
				,items: [{
				columnWidth: .5
				,layout: 'form'
				,items: [{xtype: 'displayfield', name: 'fullname', fieldLabel: _('cs_user'), anchor: '100%', style: 'font-size:1.1em;'}]
			},{
				columnWidth: .5
				,layout: 'form'
				,items: [{xtype: 'displayfield', name: 'cost', fieldLabel: _('cs_order_cost'), anchor: '100%', style: 'font-size:1.1em;'}]
			}]
			},{
				xtype: 'fieldset'
				,layout: 'column'
				,style: 'padding:15px 5px;text-align:left;'
				,defaults: {msgTarget: 'under',border: false}
				,items: [{
					columnWidth: .33
					,layout: 'form'
					,items: [
						{xtype: 'displayfield', name: 'num', fieldLabel: _('cs_num'), anchor: '100%', style: 'font-size:1.1em;'}
						,{xtype: 'displayfield', name: 'cart_cost', fieldLabel: _('cs_cart_cost'), anchor: '100%'}
					]
				},{
					columnWidth: .33
					,layout: 'form'
					,items: [
						{xtype: 'displayfield', name: 'createdon', fieldLabel: _('cs_createdon'), anchor: '100%'}
						,{xtype: 'displayfield', name: 'delivery_cost', fieldLabel: _('cs_delivery_cost'), anchor: '100%'}
					]
				},{
					columnWidth: .33
					,layout: 'form'
					,items: [
						{xtype: 'displayfield', name: 'updatedon', fieldLabel: _('cs_updatedon'), anchor: '100%'}
						,{xtype: 'displayfield', name: 'weight', fieldLabel: _('cs_weight'), anchor: '100%'}
					]
				}]
			},{
				layout: 'column'
				,defaults: {msgTarget: 'under',border: false}
				,anchor: '100%'
				,items: [{
					columnWidth: .48
					,layout: 'form'
					,items: [
						{xtype: 'cybershop-combo-status', name: 'status', fieldLabel: _('cs_status'), anchor: '100%', order_id: config.record.id}
						,{xtype: 'cybershop-combo-delivery', name: 'delivery', fieldLabel: _('cs_delivery'), anchor: '100%'}
						,{xtype: 'cybershop-combo-payment', name: 'payment', fieldLabel: _('cs_payment'), anchor: '100%', delivery_id: config.record.delivery}
					]
				},{
					columnWidth: .5
					,layout: 'form'
					,items: [
						{xtype: 'textarea', name: 'comment', fieldLabel: _('cs_comment'), anchor: '100%', height: 155}
					]
				}]
			}
		];
	}

	,getAddressFields: function(config) {
		return [
			{
				layout: 'column'
				,defaults: {msgTarget: 'under',border: false}
				,items: [{
					columnWidth: .7
					,layout: 'form'
					,items: [{xtype: 'textfield', name: 'addr_receiver', fieldLabel: _('cs_receiver'), anchor: '100%'}]
				},{
					columnWidth: .3
					,layout: 'form'
					,items: [{xtype: 'textfield', name: 'addr_phone', fieldLabel: _('cs_phone'), anchor: '100%'}]
				}]
			},{
				layout: 'column'
				,defaults: {msgTarget: 'under',border: false}
				,items: [{
					columnWidth: .3
					,layout: 'form'
					,items: [{xtype: 'textfield', name: 'addr_index', fieldLabel: _('cs_index'), anchor: '100%'}]
				},{
					columnWidth: .7
					,layout: 'form'
					,items: [{xtype: 'textfield', name: 'addr_country', fieldLabel: _('cs_country'), anchor: '100%'}]
				}]
			},{
				layout: 'column'
				,defaults: {msgTarget: 'under',border: false}
				,items: [{
					columnWidth: .5
					,layout: 'form'
					,items: [
						{xtype: 'textfield', name: 'addr_region', fieldLabel: _('cs_region'), anchor: '100%'}
						,{xtype: 'textfield', name: 'addr_metro', fieldLabel: _('cs_metro'), anchor: '100%'}
						,{xtype: 'textfield', name: 'addr_building', fieldLabel: _('cs_building'), anchor: '100%'}
					]
				},{
					columnWidth: .5
					,layout: 'form'
					,items: [
						{xtype: 'textfield', name: 'addr_city', fieldLabel: _('cs_city'), anchor: '100%'}
						,{xtype: 'textfield', name: 'addr_street', fieldLabel: _('cs_street'), anchor: '100%'}
						,{xtype: 'textfield', name: 'addr_room', fieldLabel: _('cs_room'), anchor: '100%'}
					]
				}]
			}
			,{xtype: 'displayfield', name: 'addr_comment', fieldLabel: _('cs_comment'), anchor: '100%'}
		];
	}

});
Ext.reg('cybershop-window-order',Cybershop.window.UpdateOrder);




/*------------------------------------*/
Cybershop.grid.Logs = function(config) {
	config = config || {};

	Ext.applyIf(config,{
		id: this.ident
		,url: Cybershop.config.connectorUrl
		,baseParams: {
			action: 'mgr/orders/getlog'
			,order_id: config.order_id
			,type: 'status'
		}
		,fields: ['id','user_id','username','fullname','timestamp','action','entry']
		,pageSize: Math.round(MODx.config.default_per_page / 2)
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,columns: [
			{header: _('cs_id'),dataIndex: 'id', hidden: true, sortable: true, width: 50}
			,{header: _('cs_username'),dataIndex: 'username', width: 75}
			,{header: _('cs_fullname'),dataIndex: 'fullname', width: 100}
			,{header: _('cs_timestamp'),dataIndex: 'timestamp', sortable: true, width: 75}
			,{header: _('cs_action'),dataIndex: 'action', width: 50}
			,{header: _('cs_entry'),dataIndex: 'entry', width: 50}
		]
	});
	Cybershop.grid.Logs.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.grid.Logs,MODx.grid.Grid,{
        setFilter: function() {
            this.getStore().baseParams.order_id = this.config.filterId;
            this.getBottomToolbar().changePage(1);
            this.refresh();
            return true;
        }
});
Ext.reg('cybershop-grid-order-logs',Cybershop.grid.Logs);


Cybershop.grid.Products = function(config) {
	config = config || {};

	Ext.applyIf(config,{
		id: this.ident
		,url: Cybershop.config.connectorUrl
		,baseParams: {
			action: 'mgr/orders/product/getlist'
			,order_id: config.order_id
			,type: 'status'
		}
		,fields: ['id','product_id','complect_id','product_name','product_article','product_image'
                         ,'complect_name','complect_image','weight','count','price','cost']
		,pageSize: Math.round(MODx.config.default_per_page / 2)
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,columns: [
			{header: _('cs_id'),dataIndex: 'id', hidden: true, sortable: true, width: 40}
			,{header: _('cs_id'), dataIndex: 'product_id', hidden: false, sortable: true, width: 40}
			,{header: _('cs_image'),dataIndex: 'product_image', sortable: false, renderer: this.renderImg, width: 50}
                        ,{header: _('cs_name'),dataIndex: 'product_name', width: 150}
			,{header: _('cs_article'),dataIndex: 'product_article', width: 100}
                        ,{header: _('cs_complect_name'),dataIndex: 'complect_name', width: 100}
                        ,{header: _('cs_complect_image'),dataIndex: 'complect_image', hidden: true, sortable: false, renderer: this.renderImg, width: 100}
			,{header: _('cs_weight'),dataIndex: 'weight', sortable: true, width: 50}
			,{header: _('cs_price'),dataIndex: 'price', sortable: true, width: 50}
			,{header: _('cs_count'),dataIndex: 'count', sortable: true, width: 50}
			,{header: _('cs_cost'),dataIndex: 'cost', width: 50}
		]
//		,tbar: [{
//			xtype: 'cybershop-combo-product'
//			,allowBlank: true
//			,width: '50%'
//			,listeners: {
//				select: {fn: this.addOrderProduct, scope: this}
//			}
//		}]
		,listeners: {
			rowDblClick: function(grid, rowIndex, e) {
				var row = grid.store.getAt(rowIndex);
				this.updateOrderProduct(grid, e, row);
			}
		}
	});
	Cybershop.grid.Products.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.grid.Products,MODx.grid.Grid, {

	getMenu: function() {
		var m = [];
		m.push({
			text: _('cs_menu_update')
			,handler: this.updateOrderProduct
		});
		m.push('-');
		m.push({
			text: _('cs_menu_remove')
			,handler: this.removeOrderProduct
		});
		this.addContextMenuItem(m);
	}

	,addOrderProduct: function(combo, row, e) {
		var id = row.id;
		combo.reset();

		MODx.Ajax.request({
			url: Cybershop.config.connectorUrl
			,params: {
				action: 'mgr/oreders/product/get'
				,id: id
			}
			,listeners: {
				success: {fn:function(r) {
					 var w = Ext.getCmp('cybershop-window-orderproduct-update');
					 if (w) {w.hide().getEl().remove();}

					r.object.order_id = this.config.order_id;
					r.object.count = 1;
					console.log(r.object);
					 w = MODx.load({
						 xtype: 'cybershop-window-orderproduct-update'
						 ,id: 'cybershop-window-orderproduct-update'
						 ,record:r.object
						 ,action: 'mgr/orders/product/create'
						 ,listeners: {
							 success: {fn:function() {
								 Cybershop.grid.Orders.changed = true;
								 this.refresh();
							 },scope:this}
							 ,hide: {fn: function() {this.getEl().remove();}}
						 }
					 });
					 w.fp.getForm().reset();
					 w.fp.getForm().setValues(r.object);
					 w.show(e.target,function() {w.setPosition(null,100)},this);
				},scope:this}
			}
		});
	}

	,updateOrderProduct: function(btn,e,row) {
		if (typeof(row) != 'undefined') {this.menu.record = row.data;}
		var id = this.menu.record.id;

		MODx.Ajax.request({
			url: Cybershop.config.connectorUrl
			,params: {
				action: 'mgr/orders/product/get'
				,id: id
			}
			,listeners: {
				success: {fn:function(r) {
					var w = Ext.getCmp('cybershop-window-orderproduct-update');
					if (w) {w.hide().getEl().remove();}

					r.object.order_id = this.config.order_id;
					w = MODx.load({
						xtype: 'cybershop-window-orderproduct-update'
						,id: 'cybershop-window-orderproduct-update'
						,record:r.object
						,action: 'mgr/orders/product/update'
						,listeners: {
							success: {fn:function() {
								Cybershop.grid.Orders.changed = true;
								this.refresh();
							},scope:this}
							,hide: {fn: function() {this.getEl().remove();}}
						}
					});
					w.fp.getForm().reset();
					w.fp.getForm().setValues(r.object);
					w.show(e.target,function() {w.setPosition(null,100)},this);
				},scope:this}
			}
		});
	}

	,removeOrderProduct: function(btn,e) {
		if (!this.menu.record) return false;

		MODx.msg.confirm({
			title: _('cs_menu_remove')
			,text: _('cs_menu_remove_confirm')
			,url: Cybershop.config.connectorUrl
			,params: {
				action: 'mgr/orders/product/remove'
				,id: this.menu.record.id
			}
			,listeners: {
				success: {fn:function(r) { this.refresh(); },scope:this}
			}
		});
		return true;
	}
        ,setFilter: function() {
            this.getStore().baseParams.order_id = this.config.filterId;
            this.getBottomToolbar().changePage(1);
            this.refresh();
            return true;
        }
        ,renderImg: function(v,md,rec) {
        var image_path = v!='' ? MODx.config.base_url+'connectors/system/phpthumb.php?w=80&h=80&src='+MODx.config.base_url+v : '';
        var out = image_path!='' ? '<img src="'+image_path+'" width="50" alt="'+v+'" title="'+v+'" />' : '';
        return out;
        }
        
});
Ext.reg('cybershop-grid-order-products',Cybershop.grid.Products);


Cybershop.window.OrderProduct = function(config) {
	config = config || {};
	this.ident = config.ident || 'meuitem'+Ext.id();
	Ext.applyIf(config,{
		title: _('cs_menu_update')
		,autoHeight: true
		,width: 600
		,url: Cybershop.config.connectorUrl
		,action: 'mgr/orders/product/update'
		,fields: [
			{xtype: 'hidden',name: 'id'}
			,{xtype: 'hidden',name: 'order_id'}
			,{
				layout:'column'
				,border: false
				,anchor: '100%'
				,items: [
					{columnWidth: .3,layout: 'form',defaults: { msgTarget: 'under' }, border:false, items: [
						{xtype: 'numberfield', fieldLabel: _('cs_product_count'), name: 'count', anchor: '100%', allowNegative: false, allowBlank: false}
					]}
					,{columnWidth: .7,layout: 'form',defaults: { msgTarget: 'under' }, border:false, items: [
						{xtype: 'textfield', fieldLabel: _('cs_name'), name: 'name', anchor: '100%', disabled: true }
					]}
				]
			}
			,{
				layout:'column'
				,border: false
				,anchor: '100%'
				,items: [
					{columnWidth: .5,layout: 'form',defaults: { msgTarget: 'under' }, border:false, items: [
						{xtype: 'numberfield', decimalPrecision: 2, fieldLabel: _('cs_product_price'), name: 'price', anchor: '100%'}
					]}
					,{columnWidth: .5,layout: 'form',defaults: { msgTarget: 'under' }, border:false, items: [
						{xtype: 'numberfield', decimalPrecision: 3, fieldLabel: _('cs_product_weight'), name: 'weight', anchor: '100%'}
					]}
				]
			}
			,{xtype: 'textarea',fieldLabel: _('cs_product_options'), name: 'options', height: 100, anchor: '100%'}
		]
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	Cybershop.window.OrderProduct.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.window.OrderProduct,MODx.Window);
Ext.reg('cybershop-window-orderproduct-update',Cybershop.window.OrderProduct);

Cybershop.combo.Product = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		id: 'cybershop-combo-product'
		,fieldLabel: _('cs_product_name')
		,fields: ['id','pagetitle']
		,valueField: 'id'
		,displayField: 'pagetitle'
		,name: 'product'
		,hiddenName: 'product'
		,allowBlank: false
		,url: Cybershop.config.connectorUrl
		,baseParams: {
			action: 'mgr/catalog/getlist'
			,combo: 1
			,id: config.value
		}
		,tpl: new Ext.XTemplate(''
			+'<tpl for="."><div class="cybershop-product-list-item">'
				+'<tpl if="parents">'
					+'<span class="parents">'
						+'<tpl for="parents">'
							+'<nobr><small>{pagetitle} / </small></nobr>'
						+'</tpl>'
					+'</span>'
			+'</tpl>'
				+'<span><small>({id})</small> <b>{pagetitle}</b></span>'
			+'</div></tpl>',{
			compiled: true
		})
		,itemSelector: 'div.cybershop-product-list-item'
		,pageSize: 20
		,emptyText: _('cs_combo_select')
		//,typeAhead: true
		,editable: true
	});
	Cybershop.combo.Product.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.combo.Product,MODx.combo.ComboBox);
Ext.reg('cybershop-combo-product',Cybershop.combo.Product);
