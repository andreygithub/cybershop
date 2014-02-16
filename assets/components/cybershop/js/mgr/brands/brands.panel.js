Cybershop.panel.Brands = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h3>'+_('cybershop')+ ': ' + _('cs_brands') + '</h3>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
                    xtype: 'cybershop-grid-brands'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                    ,border: true
        }]
    });
    Cybershop.panel.Brands.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.panel.Brands,MODx.Panel);
Ext.reg('cybershop-panel-brands',Cybershop.panel.Brands);
