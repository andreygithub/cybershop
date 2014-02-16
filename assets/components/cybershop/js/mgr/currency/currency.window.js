Cybershop.window.Currency = function(config) {
    config = config || {};
    config.id = Ext.id();
    Ext.applyIf(config,{
        url: Cybershop.config.connectorUrl
        ,id: config.id
        ,width: 600
        ,labelAlign: 'left'
        ,labelWidth: 180
        ,baseParams: {
            action: 'mgr/currency/update'
        }
        ,fields:
        [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('cs_name')
            ,name: 'name'
            ,allowBlank: false
            ,anchor: '99%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('cs_shortname')
            ,name: 'shortname'
            ,allowBlank: true
            ,anchor: '99%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('cs_description')
            ,name: 'description'
            ,allowBlank: true
            ,anchor: '99%'
        },{
            xtype: 'numberfield'
            ,decimalPrecision: 5
            ,fieldLabel: _('cs_rate')
            ,name: 'rate'
            ,allowBlank: true
            ,anchor: '99%'
       },{
            xtype: 'modx-combo-browser'
            ,fieldLabel: _('cs_image')
            ,name: 'image'
            ,anchor: '99%'
            ,source: '1' 
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('cs_main')
            ,name: 'main'
            ,style: 'height: 30px;'
            ,anchor: '99%'
        }]
    });
    Cybershop.window.Currency.superclass.constructor.call(this,config);
    this.on('show',function() {
        if (this.config.blankValues) { 
            this.blankValues = true;
            this.fp.getForm().reset();
            this.fp.getForm().baseParams = this.config.baseParams;
         }
        if (this.config.allowDrop) { this.loadDropZones(); }
        this.syncSize();
        this.focusFirstField();
    },this);
};
Ext.extend(Cybershop.window.Currency,MODx.Window);
Ext.reg('cybershop-window-currency',Cybershop.window.Currency);
