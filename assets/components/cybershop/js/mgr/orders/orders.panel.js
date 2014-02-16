Cybershop.panel.Orders = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h3>'+_('cybershop')+ ': ' + _('cs_orders') + '</h3>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
                    xtype: 'cybershop-grid-orders'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                    ,border: true
        }]
    });
    Cybershop.panel.Orders.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.panel.Orders,MODx.Panel);
Ext.reg('cybershop-panel-orders',Cybershop.panel.Orders);
