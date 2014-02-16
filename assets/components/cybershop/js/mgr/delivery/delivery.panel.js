Cybershop.panel.Delivery = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h3>'+_('cybershop')+ ': ' + _('cs_delivery') + '</h3>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
                    xtype: 'cybershop-grid-delivery'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                    ,border: true
        }]
    });
    Cybershop.panel.Delivery.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.panel.Delivery,MODx.Panel);
Ext.reg('cybershop-panel-delivery',Cybershop.panel.Delivery);
