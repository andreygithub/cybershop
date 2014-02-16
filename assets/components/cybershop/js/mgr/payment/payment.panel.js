Cybershop.panel.Payment = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h3>'+_('cybershop')+ ': ' + _('cs_payment') + '</h3>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
                    xtype: 'cybershop-grid-payment'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                    ,border: true
        }]
    });
    Cybershop.panel.Payment.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.panel.Payment,MODx.Panel);
Ext.reg('cybershop-panel-payment',Cybershop.panel.Payment);
