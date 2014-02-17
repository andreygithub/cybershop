Cybershop.window.catalog_import = function(config) {
    config = config || {};
    config.id = Ext.id();
    Ext.applyIf(config,{
        id: config.id
        ,title: 'Импорт файлов'
        ,width: 600
        ,labelAlign: 'top'
        ,labelWidth: 180              
        ,fields:
        [{  
            id: 'cs-import-file'
            ,xtype: 'cybershop-combo-browser'
            ,fieldLabel: 'Выберите файл импорта'
            ,name: 'file'
            ,anchor: '99%'
            ,rootId: Cybershop.config.catalog_import_path
        },{
            id: 'cs-import-result'
            ,xtype: 'panel'
            ,fieldLabel: 'Console'
            ,border: true
            ,anchor: '99%'
            ,boxMaxHeight: 500
        }]
        ,buttons: [{
            text: config.cancelBtnText || _('cancel')
            ,scope: this
            ,handler: function() { this.hide(); }
        },{
            text: config.saveBtnText || _('cs_import')
            ,scope: this
            ,handler: function() { this.request(); }
        }]
    });
    Cybershop.window.catalog_import.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.window.catalog_import,MODx.Window,{
    request: function(){

        var fileCmp = Ext.getCmp('cs-import-file');
        var result = Ext.get('cs-import-result');
        var file = fileCmp.getValue();

        result.getUpdater().update({
            url: Cybershop.config.connectorUrl
            ,params:{
                action: 'mgr/catalog/import/start'
                ,file: file
            }
        })
    }
});
Ext.reg('cybershop-window-catalog_import',Cybershop.window.catalog_import);
