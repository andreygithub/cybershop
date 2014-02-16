Ext.onReady(function() {
    MODx.load({ xtype: 'cybershop-page-categorys'});
});
Cybershop.page.Categorys = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cybershop-panel-categorys'
            ,renderTo: 'cybershop-panel-categorys-div'
        }]
    });
    Cybershop.page.Categorys.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.page.Categorys,MODx.Component);
Ext.reg('cybershop-page-categorys',Cybershop.page.Categorys);
