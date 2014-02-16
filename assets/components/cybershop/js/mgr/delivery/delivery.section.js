Ext.onReady(function() {
    MODx.load({ xtype: 'cybershop-page-delivery'});
});
Cybershop.page.Delivery = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cybershop-panel-delivery'
            ,renderTo: 'cybershop-panel-delivery-div'
        }]
    });
    Cybershop.page.Delivery.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.page.Delivery,MODx.Component);
Ext.reg('cybershop-page-delivery',Cybershop.page.Delivery);