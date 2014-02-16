Cybershop.panel.Categorys = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h3>'+_('cybershop')+ ': ' + _('cs_categorys') + '</h3>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
                    xtype: 'cybershop-tree-categorys'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                    ,border: true
        }]
    });
    Cybershop.panel.Categorys.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.panel.Categorys,MODx.Panel);
Ext.reg('cybershop-panel-categorys',Cybershop.panel.Categorys);