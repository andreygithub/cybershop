Cybershop.panel.Status = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h3>'+_('cybershop')+ ': ' + _('cs_status') + '</h3>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
                    xtype: 'cybershop-grid-status'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                    ,border: true
        }]
    });
    Cybershop.panel.Status.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.panel.Status,MODx.Panel);
Ext.reg('cybershop-panel-status',Cybershop.panel.Status);
