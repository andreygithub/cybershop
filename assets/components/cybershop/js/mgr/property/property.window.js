Cybershop.window.Property = function(config) {
    config = config || {};
    config.id = Ext.id();
    Ext.applyIf(config,{
        title: _('cs_element_update')
        ,url: Cybershop.config.connectorUrl
        ,id: config.id
        ,baseParams: {
            action: 'mgr/property/update'
        }
        ,width: 700  
        ,minWidth:700
        ,fields:
            [{
                xtype: 'panel'
                ,border: false
                ,cls:'main-wrapper'
                ,layout: 'form'
                ,labelAlign: 'top'
                ,labelSeparator: ''
                ,items: [{
                    xtype: 'modx-tabs'
                    ,defaults: {
                                autoHeight: true
                                ,border: true
                                ,bodyCssClass: 'tab-panel-wrapper'
                                }
                    ,forceLayout: true
                    ,deferredRender: false
                    ,items: 
                        [{
                            title: _('cs_tabs_main')
                            ,layout: 'form'
                            ,items: 
                                [{
                                    xtype: 'hidden'
                                    ,name: 'id'
                                 },{
                                    xtype: 'textfield'
                                    ,fieldLabel: _('cs_name')
                                    ,name: 'name'
                                    ,anchor: '99%'
                                },{
                                    xtype: 'textfield'
                                    ,fieldLabel: _('cs_description')
                                    ,name: 'description'
                                    ,anchor: '99%'
                                },{
                                    xtype: 'textfield'
                                    ,fieldLabel: _('cs_shortname')
                                    ,name: 'shortname'
                                    ,anchor: '99%'
                                },{
                                    xtype: 'cybershop-combo-xtype-spec'
                                    ,fieldLabel: _('xtype')
                                    ,id: config.id + '-xtype'
                                    ,anchor: '99%'
                                }]
                         },{
                             title: _('cs_tabs_add')
                            ,layout: 'form'
                            ,items:
                                [{
                                    xtype: 'modx-combo-browser'
                                    ,fieldLabel: _('cs_image')
                                    ,name: 'image'
                                    ,anchor: '99%'
                                    ,source: '2' 
                                },{
                                    xtype: 'textarea'
                                    ,fieldLabel: _('cs_introtext')
                                    ,name: 'introtext'
                                    ,anchor: '99%'
                                },{
                                    xtype: 'htmleditor'
                                    ,hideLabel: true
                                    ,fieldLabel: _('cs_fulltext')
                                    ,name: 'fulltext'
                                    ,anchor: '99%'
                                    ,minWidth: 700
                                    ,handler: function(){
                                        Ext.get('styleswitcher').on('click', function(e){
                                            Ext.getCmp('form-widgets').getForm().reset();
                                        });
                                    }
                                }]
                         },{
                            title: _('cs_tabs_ceo')
                            ,layout: 'form'
                            ,items:  
                                [{
                                    xtype: 'textfield'
                                    ,fieldLabel: _('cs_ceo_data')
                                    ,name: 'ceo_data'
                                    ,anchor: '99%'
                                },{
                                    xtype: 'textfield'
                                    ,fieldLabel: _('cs_ceo_key')
                                    ,name: 'ceo_key'
                                    ,anchor: '99%'
                                },{
                                    xtype: 'textarea'
                                    ,fieldLabel: _('cs_ceo_description')
                                    ,name: 'ceo_description'
                                    ,anchor: '99%'                                
                                }]
                         }]
                }]
            }]        
            ,buttons: [{
                text: config.cancelBtnText || _('cancel')
                ,scope: this
                ,handler: function() { this.hide(); }
            },{
                text: config.saveBtnText || _('save')
                ,scope: this
                ,handler: function() { this.submit(false); }
            },{
                text: config.saveBtnText || _('save_and_close')
                ,scope: this
                ,handler: this.submit
            }]
        
    });
    Cybershop.window.Property.superclass.constructor.call(this,config);
  
};

Ext.extend(Cybershop.window.Property,MODx.Window);
Ext.reg('cybershop-window-property',Cybershop.window.Property);

Cybershop.combo.xType = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.SimpleStore({
            fields: ['d','v']
            ,data: [[_('textfield'),'textfield']
                ,[_('textarea'),'textarea']
                ,[_('numberfield'),'numberfield']
                ,[_('yesno'),'combo-boolean']
            ]
        })
        ,displayField: 'd'
        ,valueField: 'v'
        ,mode: 'local'
        ,name: 'xtype'
        ,hiddenName: 'xtype'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: false
        ,value: 'textfield'
    });
    Cybershop.combo.xType.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.combo.xType,Ext.form.ComboBox);
Ext.reg('cybershop-combo-xtype-spec',Cybershop.combo.xType);
