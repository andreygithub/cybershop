Ext.onReady(function() {
    MODx.load({ xtype: 'cybershop-page-property'});
});
Cybershop.page.Property = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cybershop-panel-property'
            ,renderTo: 'cybershop-panel-property-div'
        }]
    });
    Cybershop.page.Property.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.page.Property,MODx.Component);
Ext.reg('cybershop-page-property',Cybershop.page.Property);