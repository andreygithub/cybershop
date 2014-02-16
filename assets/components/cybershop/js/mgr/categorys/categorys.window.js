Cybershop.window.Categorys = function(config) {
    config = config || {};
    config.id = Ext.id();
    Ext.applyIf(config,{
        title: _('cs_element_update')
        ,
        id: config.id
        ,
        url: Cybershop.config.connectorUrl
        ,
        baseParams: {
            action: 'mgr/categorys/update'
        }
        ,
        width: 700  
        ,
        minWidth:700 
        ,
        fields:
        [{
            xtype: 'hidden',
            name: 'id'
        },{
            xtype: 'panel',
            border: false,
            cls:'main-wrapper',
            layout: 'form',
            labelAlign: 'top',
            labelSeparator: '',
            items: [{
                xtype: 'modx-tabs',
                defaults: {
                    autoHeight: true,
                    border: true,
                    bodyCssClass: 'tab-panel-wrapper'
                },
                forceLayout: true,
                deferredRender: false,
                items: 
                [{
                    title: _('cs_tabs_main'),
                    layout: 'form',
                    items: 
                    [{
                        layout: 'column',
                        border: false,
                        items: 
                        [{
                            columnWidth: .6,
                            layout: 'form',
                            items: 
                            [{
                                xtype: 'textfield',
                                fieldLabel: _('cs_name'),
                                name: 'name',
                                anchor: '100%'
                            },{
                                xtype: 'textfield',
                                fieldLabel: _('cs_description'),
                                name: 'description',
                                anchor: '100%'
                            },{
                                xtype: 'textarea',
                                fieldLabel: _('cs_introtext'),
                                name: 'introtext',
                                anchor: '100%'
                            }]
                        },    {
                            columnWidth: .4,
                            layout: 'form',
                            items:
                            [{
                                xtype: 'textfield',
                                fieldLabel: _('cs_alias') + ' <small>' + _('cs_alias_desc') + '</small>',
                                name: 'alias',
                                anchor: '100%'   
                            },{
                                xtype: 'textfield',
                                fieldLabel: _('cs_parent_id'),
                                name: 'parent',
                                anchor: '100%'
                            },{
                                xtype: 'combo-boolean',
                                fieldLabel: _('cs_isFolder'),
                                renderer: 'boolean',
                                name: 'isfolder',
                                hiddenName: 'isfolder',
                                anchor: '100%'  
                            },{                                
                                xtype: 'numberfield',
                                fieldLabel: _('cs_sort_position'),
                                name: 'sort_position',
                                allowNegative: false,
                                allowDecimals: false,
                                hiddenName: 'sort_position',
                                anchor: '100%'                                  
                            }]
                        }]
                    },{
                        xtype: 'htmleditor',
                        hideLabel: true,
                        fieldLabel: _('cs_fulltext'),
                        name: 'fulltext',
                        anchor: '99%',
                        minWidth: 700,
                        handler: function(){
                            Ext.get('styleswitcher').on('click', function(e){
                                Ext.getCmp('form-widgets').getForm().reset();
                            });
                        }

                    }]
                },{
                    title: _('cs_tabs_filters')
                    ,
                    layout: 'form'
                    ,
                    items: 
                    [{
                        xtype: 'cybershop-grid-filtertable',
                        id: config.id+'-window-grid',
                        winid: config.id,
                        fieldLabel: _('cs_filters'),
                        name: 'id',
                        anchor: '99%' 
                    }]

                },{
                    title: _('cs_tabs_add'),
                    layout: 'form',
                    items: 
                    [{
                        xtype: 'textfield',
                        fieldLabel: _('cs_url'),
                        name: 'url',
                        anchor: '99%'
                    },{
                        xtype: 'modx-combo-browser',
                        fieldLabel: _('cs_image'),
                        name: 'image',
                        anchor: '99%',
                        source: '2'
                    }]

                },{
                    title: _('cs_tabs_ceo')
                    ,
                    layout: 'form'
                    ,
                    items:  
                    [{
                        xtype: 'textfield'
                        ,
                        fieldLabel: _('cs_ceo_data')
                        ,
                        name: 'ceo_data'
                        ,
                        anchor: '99%'
                    },{
                        xtype: 'textfield'
                        ,
                        fieldLabel: _('cs_ceo_key')
                        ,
                        name: 'ceo_key'
                        ,
                        anchor: '99%'
                    },{
                        xtype: 'textarea'
                        ,
                        fieldLabel: _('cs_ceo_description')
                        ,
                        name: 'ceo_description'
                        ,
                        anchor: '99%'                                
                    }]
                }]
            }]
        }]
        ,
        buttons: [{
            text: config.cancelBtnText || _('cancel')
            ,
            scope: this
            ,
            handler: function() {
                this.hide();
            }
        },{
            text: config.saveBtnText || _('save')
            ,
            scope: this
            ,
            handler: function() {
                this.submit(false);
            }
        },{
            text: config.saveBtnText || _('save_and_close')
            ,
            scope: this
            ,
            handler: this.submit
        }]
    });
    Cybershop.window.Categorys.superclass.constructor.call(this,config);
        
    this.on('show',function() {
        if (this.config.blankValues) { 
            this.fp.getForm().reset();
            this.blankValues = true;
            this.fp.getForm().baseParams = this.config.baseParams;
            this.config.filterId = -1;
            this.setTableFilter(this.config.filterId);
        }
        else {
            this.setTableFilter(this.fp.getForm().items.itemAt(0).getValue());
        }
        if (this.config.allowDrop) {
            this.loadDropZones();
        }
        this.syncSize();
        this.focusFirstField();
    },this);
};
Ext.extend(Cybershop.window.Categorys,MODx.Window,{
    savenew: function() {
        var f = this.fp.getForm();

        f.submit({
            waitMsg: _('saving')
            ,
            scope: this
            ,
            failure: function(frm,a) {
                if (this.fireEvent('failure',{
                    f:frm,
                    a:a
                })) {
                    MODx.form.Handler.errorExt(a.result,frm);
                }
            }
            ,
            success: function(frm,a) {

                if (this.config.success) {
                    Ext.callback(this.config.success,this.config.scope || this,[frm,a]);
                        
                }
                this.fireEvent('success',{
                    f:frm,
                    a:a
                });
                var r = Ext.decode(a.response.responseText);
                this.setValues(r.object);
                this.fp.getForm().baseParams = {
                    action: 'mgr/categorys/update'
                };
                this.blankValues = false;
                this.setTableFilter(this.fp.getForm().items.itemAt(0).getValue());

            }
        });


    }
    ,
    setTableFilter: function(filterId) {
        Ext.getCmp(this.config.id+'-window-grid').config.filterId = filterId;
        Ext.getCmp(this.config.id+'-window-grid').setFilter();
    }

});
Ext.reg('cybershop-window-categorys',Cybershop.window.Categorys);

