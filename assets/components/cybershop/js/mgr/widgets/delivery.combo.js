Cybershop.combo.Delivery = function(config) {
	config = config || {};

	Ext.applyIf(config,{
		name: 'delivery'
		,id: 'cybershop-combo-delivery'
		,hiddenName: 'delivery'
		,displayField: 'name'
		,valueField: 'id'
		,fields: ['id','name']
		,pageSize: 10
		,emptyText: _('cs_combo_select')
		,url: Cybershop.config.connectorUrl
		,baseParams: {
			action: 'mgr/delivery/getlist'
			,combo: true
			//,addall: config.addall || 0
			//,order_id: config.order_id || 0
		}
		,listeners: {
			render: function() {
				this.store.on('load', function() {
					if (this.store.getTotalCount() == 1 && this.store.getAt(0).id == this.value) {
						this.readOnly = true;
						this.addClass('disabled');
					}
					else {
						this.readOnly = false;
						this.removeClass('disabled');
					}
				}, this);
			}
			,select: function(combo,row) {
				var payments = Ext.getCmp('cybershop-combo-payment');
				var store = payments.getStore();
				payments.setValue('');
				store.baseParams.delivery_id = row.id;
				store.load();
			}
		}
	});
	Cybershop.combo.Delivery.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.combo.Delivery,MODx.combo.ComboBox);
Ext.reg('cybershop-combo-delivery',Cybershop.combo.Delivery);