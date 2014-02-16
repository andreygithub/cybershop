Cybershop.combo.Payment = function(config) {
	config = config || {};

	Ext.applyIf(config,{
		name: 'payment'
		,id: 'cybershop-combo-payment'
		,hiddenName: 'payment'
		,displayField: 'name'
		,valueField: 'id'
		,fields: ['id','name']
		,pageSize: 10
		,emptyText: _('cs_combo_select')
		,url: Cybershop.config.connectorUrl
		,baseParams: {
			action: 'mgr/payment/getlist'
			,combo: true
			//,addall: config.addall || 0
			,delivery_id: config.delivery_id || 0
		}
	});
	Cybershop.combo.Payment.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.combo.Payment,MODx.combo.ComboBox);
Ext.reg('cybershop-combo-payment',Cybershop.combo.Payment);