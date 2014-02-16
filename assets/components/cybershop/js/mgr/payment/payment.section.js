Ext.onReady(function() {
    MODx.load({ xtype: 'cybershop-page-payment'});
});
Cybershop.page.Payment = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cybershop-panel-payment'
            ,renderTo: 'cybershop-panel-payment-div'
        }]
    });
    Cybershop.page.Payment.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.page.Payment,MODx.Component);
Ext.reg('cybershop-page-payment',Cybershop.page.Payment);