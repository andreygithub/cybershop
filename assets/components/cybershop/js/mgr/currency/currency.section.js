Ext.onReady(function() {
    MODx.load({ xtype: 'cybershop-page-currency'});
});
Cybershop.page.Currency = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cybershop-panel-currency'
            ,renderTo: 'cybershop-panel-currency-div'
        }]
    });
    Cybershop.page.Currency.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.page.Currency,MODx.Component);
Ext.reg('cybershop-page-currency',Cybershop.page.Currency);