Ext.onReady(function() {
    MODx.load({ xtype: 'cybershop-page-orders'});
});
Cybershop.page.Orders = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cybershop-panel-orders'
            ,renderTo: 'cybershop-panel-orders-div'
        }]
    });
    Cybershop.page.Orders.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.page.Orders,MODx.Component);
Ext.reg('cybershop-page-orders',Cybershop.page.Orders);