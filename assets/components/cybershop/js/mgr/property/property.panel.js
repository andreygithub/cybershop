Cybershop.panel.Property = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h3>'+_('cybershop')+ ': ' + _('cs_properties') + '</h3>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
                    xtype: 'cybershop-grid-property'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                    ,border: true
        }]
    });
    Cybershop.panel.Property.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.panel.Property,MODx.Panel);
Ext.reg('cybershop-panel-property',Cybershop.panel.Property);
