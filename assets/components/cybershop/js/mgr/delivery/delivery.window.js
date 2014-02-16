Cybershop.window.Delivery = function(config) {
    config = config || {};
    config.id = Ext.id();
    Ext.applyIf(config,{
        url: Cybershop.config.connectorUrl
        ,id: config.id
        ,baseParams: {
            action: 'mgr/delivery/update'
        }
        ,labelAlign: 'left'
        ,width: 700  
        ,minWidth:700 
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
            xtype: 'numberfield'
            ,fieldLabel: _('cs_price')
            , name: 'price'
            , description: _('cs_price_help')
            ,allowBlank: false 
            ,decimalPrecision: 2
            ,anchor: '99%'
        },{
            xtype: 'numberfield'
            ,fieldLabel: _('cs_weight_price')
            ,description: _('cs_weight_price_help')
            ,name: 'weight_price'
            ,decimalPrecision: 2
            ,allowBlank: true
            ,anchor: '99%'
        },{
            xtype: 'numberfield'
            ,fieldLabel: _('cs_distance_price')
            ,description: _('cs_distance_price_help')
            ,name: 'distance_price'
            ,decimalPrecision: 2
            ,allowBlank: true
            ,anchor: '99%'
        },{
            xtype: 'modx-combo-browser'
            ,fieldLabel: _('cs_image')
            ,name: 'image'
            ,anchor: '99%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('cs_description')
            ,name: 'description'
            ,anchor: '99%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('cs_order_requires')
            ,description: _('cs_order_requires_help')
            ,name: 'requires'
            ,anchor: '99%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('cs_class')
            ,name: 'class'
            ,anchor: '99%'
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: ''
            ,boxLabel: _('cs_active')
            ,name: 'active'
        }]
    });
    Cybershop.window.Delivery.superclass.constructor.call(this,config);
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
Ext.extend(Cybershop.window.Delivery,MODx.Window);
Ext.reg('cybershop-window-delivery',Cybershop.window.Delivery);
