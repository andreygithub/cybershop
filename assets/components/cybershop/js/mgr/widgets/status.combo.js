Cybershop.combo.Status = function(config) {
	config = config || {};

	Ext.applyIf(config,{
		name: 'status'
		,id: 'cybershop-combo-status'
		,hiddenName: 'status'
		,displayField: 'name'
		,valueField: 'id'
		,fields: ['id','name']
		,pageSize: 10
		,emptyText: _('cs_combo_select_status')
		,url: Cybershop.config.connectorUrl
		,baseParams: {
			action: 'mgr/status/getlist'
			,combo: true
			,addall: config.addall || 0
			,order_id: config.order_id || 0
		}
	});
	Cybershop.combo.Status.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.combo.Status,MODx.combo.ComboBox);
Ext.reg('cybershop-combo-status',Cybershop.combo.Status)

