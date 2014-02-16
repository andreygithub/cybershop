Ext.onReady(function() {
    MODx.load({ xtype: 'cybershop-page-filter'});
});
Cybershop.page.Filter = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cybershop-panel-filter'
            ,renderTo: 'cybershop-panel-filter-div'
        }]
    });
    Cybershop.page.Filter.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.page.Filter,MODx.Component);
Ext.reg('cybershop-page-filter',Cybershop.page.Filter);
