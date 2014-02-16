Cybershop.window.Status = function(config) {
    config = config || {};
    config.id = Ext.id();
    Ext.applyIf(config,{
        url: Cybershop.config.connectorUrl
        ,id: config.id
        ,width: 600
        ,labelAlign: 'left'
        ,labelWidth: 180
        ,baseParams: {
            action: 'mgr/status/update'
        }

        
        ,fields:
        [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'hidden'
            ,name: 'color'
            ,id: 'cs-newstatus-color'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('cs_name')
            ,name: 'name'
            ,allowBlank: false
            ,anchor: '99%'
        },{
            xtype: 'colorpalette'
            ,fieldLabel: _('cs_color')
            ,listeners: {
                    select: function(palette, setColor) {
                            Ext.getCmp('cs-newstatus-color').setValue(setColor)
                    }
                    ,beforerender: function(palette) {
                            var color = Ext.getCmp('cs-newstatus-color').value;
                            if (color != 'undefined') {
                                    palette.value = color;
                            }
                    }
            }

        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('cs_email_user')
            ,name: 'email_user'
            ,style: 'height: 30px;'
            ,anchor: '99%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('cs_subject_user')
            ,name: 'subject_user'
        },{
            xtype: 'cybershop-combo-chunk'
            ,fieldLabel: _('cs_body_user')
            ,name: 'body_user'
            ,hiddenName: 'body_user'
            ,anchor: '99%'
        },{
             xtype: 'xcheckbox'
            ,fieldLabel: _('cs_email_manager')
            ,name: 'email_manager'
            ,style: 'height: 30px;'
            ,anchor: '99%'
        },{ 
            xtype: 'textfield'
            ,fieldLabel: _('cs_subject_manager')
            ,name: 'subject_manager'
            ,anchor: '99%'
        },{
            xtype: 'cybershop-combo-chunk'
            ,fieldLabel: _('cs_body_manager')
            ,name: 'body_manager'
            ,hiddenName: 'body_manager'
            ,anchor: '99%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('cs_description')
            ,name: 'description'
            ,anchor: '99%'
        },{
            xtype: 'checkboxgroup'
            ,fieldLabel: _('cs_options')
            ,columns: 1
            ,items: [
                    {xtype: 'xcheckbox', boxLabel: _('cs_active'), name: 'active'}
                    ,{xtype: 'xcheckbox', boxLabel: _('cs_status_final'), description: _('cs_status_final_help'), name: 'final'}
                    ,{xtype: 'xcheckbox', boxLabel: _('cs_status_fixed'), description: _('cs_status_fixed_help'), name: 'fixed'}
            ]
        }]
        ,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
    });
    Cybershop.window.Status.superclass.constructor.call(this,config);
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
Ext.extend(Cybershop.window.Status,MODx.Window);
Ext.reg('cybershop-window-status',Cybershop.window.Status);

Cybershop.combo.Chunk = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		name: 'chunk'
		,hiddenName: 'chunk'
		,displayField: 'name'
		,valueField: 'id'
		,editable: true
		,fields: ['id','name']
		,pageSize: 20
		,emptyText: _('cs_combo_select')
		,hideMode: 'offsets'
		,url: Cybershop.config.connectorUrl
		,baseParams: {
			action: 'mgr/system/element/chunk/getlist'
			,mode: 'chunks'
		}
	});
	Cybershop.combo.Chunk.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.combo.Chunk,MODx.combo.ComboBox);
Ext.reg('cybershop-combo-chunk',Cybershop.combo.Chunk);
