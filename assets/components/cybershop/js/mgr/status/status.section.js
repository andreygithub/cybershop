Ext.onReady(function() {
    MODx.load({ xtype: 'cybershop-page-status'});
});
Cybershop.page.Status = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cybershop-panel-status'
            ,renderTo: 'cybershop-panel-status-div'
        }]
    });
    Cybershop.page.Status.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.page.Status,MODx.Component);
Ext.reg('cybershop-page-status',Cybershop.page.Status);