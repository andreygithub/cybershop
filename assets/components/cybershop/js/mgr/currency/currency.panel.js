Cybershop.panel.Currency = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h3>'+_('cybershop')+ ': ' + _('cs_currency') + '</h3>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
                    xtype: 'cybershop-grid-currency'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                    ,border: true
        }]
    });
    Cybershop.panel.Currency.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.panel.Currency,MODx.Panel);
Ext.reg('cybershop-panel-currency',Cybershop.panel.Currency);
