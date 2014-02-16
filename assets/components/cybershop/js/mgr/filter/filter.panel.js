Cybershop.panel.Filter = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h3>'+_('cybershop')+ ': ' + _('cs_filters') + '</h3>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
                    xtype: 'cybershop-grid-filter'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                    ,border: true
        }]
    });
    Cybershop.panel.Filter.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.panel.Filter,MODx.Panel);
Ext.reg('cybershop-panel-filter',Cybershop.panel.Filter);
