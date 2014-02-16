Ext.onReady(function() {
    MODx.load({ xtype: 'cybershop-page-catalog'});
});

Cybershop.page.Catalog = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cybershop-panel-catalog'
            ,renderTo: 'cybershop-panel-catalog-div'
        }]
    });
    Cybershop.page.Catalog.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.page.Catalog,MODx.Component);
Ext.reg('cybershop-page-catalog',Cybershop.page.Catalog);