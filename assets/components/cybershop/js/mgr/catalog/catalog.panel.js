
Cybershop.panel.Catalog = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h3>'+_('cybershop')+ ': ' + _('cs_catalog') + '</h3>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
                    xtype: 'cybershop-grid-catalog'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                    ,border: true
        }]
    });
    Cybershop.panel.Catalog.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.panel.Catalog,MODx.Panel);
Ext.reg('cybershop-panel-catalog',Cybershop.panel.Catalog);