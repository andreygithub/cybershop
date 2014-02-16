Ext.onReady(function() {
    MODx.load({ xtype: 'cybershop-page-brands'});
});
Cybershop.page.Brands = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cybershop-panel-brands'
            ,renderTo: 'cybershop-panel-brands-div'
        }]
    });
    Cybershop.page.Brands.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.page.Brands,MODx.Component);
Ext.reg('cybershop-page-brands',Cybershop.page.Brands);