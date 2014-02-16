Cybershop.grid.Complects = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/catalog/catalogcomplecttable/getList'}
        ,save_action: 'mgr/catalog/catalogcomplecttable/updateFromGrid' 
        ,fields: ['id','name','catalog'
                  ,'description','introtext'
                  ,'fulltext','image','price1','price2','price3'
                  ,'url','ceo_data'
                  ,'ceo_data','ceo_description'
                  ,'amount']
        ,paging: true
        ,pageSize: 5
        ,autosave: true
        ,remoteSort: true
        ,anchor: '99%'
        ,autoExpandColumn: 'name'
        ,columns: [{
            header: _('cs_id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 60
        },{
            header: _('cs_image')
            ,dataIndex: 'image'
            ,sortable: true
            ,renderer: this.renderItemImage
            ,width: 100
        },{
            header: _('cs_name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 100
        },{
            header: _('cs_description')
            ,dataIndex: 'description'
            ,sortable: false
            ,width: 350
        }]

	,tbar: 
            [{
                text: _('cs_element_create')
                ,handler: this.createNewElement
            }]

       
     });
    Cybershop.grid.Complects.superclass.constructor.call(this,config);

};

Ext.extend(Cybershop.grid.Complects,MODx.grid.Grid,{
        setFilter: function() {
            this.getStore().baseParams.catalog = this.config.filterId;
            this.getBottomToolbar().changePage(1);
            this.refresh();
            return true;
        }
        ,getMenu: function() {
            return [{
                 text: _('cs_element_create')
                 ,handler: this.createNewElement
            },{
                 text: _('cs_element_update')
                 ,handler: this.updateElement
            },{
                 text: _('cs_element_remove')
                 ,handler: this.removeElement
            }];
        }
        ,removeElement: function() {
            MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/catalog/catalogcomplecttable/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
            });
        }
        ,createNewElement: function() {
            parentCmp = Ext.getCmp(this.config.winid);

            if (parentCmp.blankValues){

                Ext.Msg.confirm(_('cs_element_save'),_('cs_element_save_confirm'),function(e) {
                    if (e == 'yes') {
//                        this.addListener('success',function(response){
//                            alert(response.a);
//                        },this);
                        parentCmp.savenew();
//                        this.createNewElementWindow();
                        return;
                        }
                    else {
                        return;
                    }
                },this);
            }
            else{
                this.createNewElementWindow();
                return;
            }
        }
        ,createNewElementWindow: function() {
            if (!this.createElementWindow) {
                this.createElementWindow = new MODx.load({
                        xtype: 'cybershop-window-complects'
                        ,title: _('cs_element_create')
                        ,baseParams: {action: 'mgr/catalog/catalogcomplecttable/create'}
                        ,listeners: {
                            'success': {fn:this.refresh,scope:this}
                            }
                    });
            };
            this.createElementWindow.config.blankValues = true;
            this.createElementWindow.config.winid = this.config.id;
            this.createElementWindow.config.filterId = this.config.filterId;
            this.createElementWindow.show(); 
            
                  
        }
        ,updateElement: function(n,e) {
            if (!this.updateWindow) {
                this.updateWindow = MODx.load({
                    xtype: 'cybershop-window-complects'
                    ,record: this.menu.record
                    ,listeners: {
                        'success': {fn:this.refresh,scope:this}
                    }
                });
            }
            this.updateWindow.config.filterId = this.config.filterId;
            this.updateWindow.setValues(this.menu.record);
            this.updateWindow.show(e.target);
        }
        ,renderItemImage: function(v,md,rec) {
            var image_path = v!='' ? MODx.config.base_url+'connectors/system/phpthumb.php?w=40&h=40&src='+MODx.config.base_url+v : '';
            var out = image_path!='' ? '<img src="'+image_path+'" width="40" height="40" alt="'+v+'" title="'+v+'" />' : '';
            return out;
        }
});
Ext.reg('cybershop-grid-complects',Cybershop.grid.Complects);

Cybershop.window.Complects = function(config) {
    config = config || {};
    config.id = Ext.id();
    Ext.applyIf(config,{
        title: _('cs_element_update')
        ,id: config.id
        ,url: Cybershop.config.connectorUrl
        ,baseParams: {
            action: 'mgr/catalog/catalogcomplecttable/update'
        }
        ,width: 700  
        ,minWidth:700 
        ,fields:
            [{
                xtype: 'hidden'
                ,name: 'id'
            },{
                xtype: 'hidden'
                ,id: config.id + '-catalog'
                ,name: 'catalog'
            },{
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
                                    xtype: 'textfield'
                                    ,fieldLabel: _('cs_name') + ' <small>' + _('cs_name_desc') + '</small>'
                                    ,name: 'name'
                                    ,anchor: '99%'
                                },{
                                    xtype: 'textfield'
                                    ,fieldLabel: _('cs_description') + ' <small>' + _('cs_description_desc') + '</small>'
                                    ,name: 'description'
                                    ,anchor: '99%'
                                },{
                                    xtype: 'textarea'
                                    ,fieldLabel: _('cs_introtext') + ' <small>' + _('cs_introtext_desc') + '</small>'
                                    ,name: 'introtext'
                                    ,anchor: '99%'
                                },{
                                     xtype: 'htmleditor'
                                    ,hideLabel: false
                                    ,fieldLabel: _('cs_fulltext') + ' <small>' + _('cs_fulltext_desc') + '</small>'
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
                            title: _('cs_tabs_price')
                            ,layout: 'form'
                            ,items: 
                                [{
                                    xtype: 'numberfield'
                                    ,fieldLabel: _('cs_price1') + ' <small>' + _('cs_price1_desc') + '</small>'
                                    ,name: 'price1'
                                    ,decimalPrecision: 2
                                    ,anchor: '99%'      
                                },{
                                    xtype: 'numberfield'
                                    ,fieldLabel: _('cs_price2') + ' <small>' + _('cs_price2_desc') + '</small>'
                                    ,name: 'price2'
                                    ,decimalPrecision: 2
                                    ,anchor: '99%'      
                                },{
                                    xtype: 'numberfield'
                                    ,fieldLabel: _('cs_price3') + ' <small>' + _('cs_price3_desc') + '</small>'
                                    ,name: 'price3'
                                    ,decimalPrecision: 2
                                    ,anchor: '99%'  
                                }]
                        },{
                            title: _('cs_tabs_value')
                            ,layout: 'form'
                            ,items: 
                                [{
                                    xtype: 'numberfield'
                                    ,fieldLabel: _('cs_value1') + ' <small>' + _('cs_value1_desc') + '</small>'
                                    ,name: 'value1'
                                    ,decimalPrecision: 3
                                    ,anchor: '99%'      
                                },{
                                    xtype: 'numberfield'
                                    ,fieldLabel: _('cs_value2') + ' <small>' + _('cs_value2_desc') + '</small>'
                                    ,name: 'value2'
                                    ,decimalPrecision: 3
                                    ,anchor: '99%'      
                                },{
                                    xtype: 'numberfield'
                                    ,fieldLabel: _('cs_value3') + ' <small>' + _('cs_value3_desc') + '</small>'
                                    ,name: 'value3'
                                    ,decimalPrecision: 3
                                    ,anchor: '99%'  
                                },{
                                    xtype: 'numberfield'
                                    ,fieldLabel: _('cs_weight') + ' <small>' + _('cs_weight_desc') + '</small>'
                                    ,name: 'weight'
                                    ,decimalPrecision: 3
                                    ,anchor: '99%' 
                                }]
                        },{
                            title: _('cs_tabs_add')
                            ,layout: 'form'
                            ,items: 
                                [{
                                    xtype: 'numberfield'
                                    ,fieldLabel: _('cs_sort_position')
                                    ,name: 'sort_position'
                                    ,decimalPrecision: 0
                                    ,anchor: '99%'
                                 },{                                    
                                    xtype: 'numberfield'
                                    ,fieldLabel: _('cs_amount')
                                    ,name: 'amount'
                                    ,decimalPrecision: 3
                                    ,anchor: '99%'
                                 },{
                                    xtype: 'textfield'
                                    ,fieldLabel: _('cs_url')
                                    ,name: 'url'
                                    ,anchor: '99%'
                                 },{
                                    xtype: 'cybershop-combo-browser'
                                    ,id: config.id+'-image'
                                    ,fieldLabel: _('cs_image')
                                    ,name: 'image'
                                    ,anchor: '99%'
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
                         },{
                            title: _('cs_tabs_properties')
                            ,layout: 'form'
                            ,items: 
                                [{
                                    xtype: 'textarea'
                                    ,fieldLabel: _('cs_properties')
                                    ,name: 'properties'
                                    ,anchor: '99%'
                                    ,height: 400
                                }]
                         }]
                }]
            }]
    });
    Cybershop.window.Complects.superclass.constructor.call(this,config);
    
    this.on('show',function() {
        var filter = this.config.filterId;
        Ext.getCmp(config.id + '-catalog').setValue(filter);
        Ext.getCmp(this.config.id+'-image').config.rootId = Cybershop.config.catalog_image_path + 'catalog/' + filter + '/'
    },this);
};

Ext.extend(Cybershop.window.Complects,MODx.Window);
Ext.reg('cybershop-window-complects',Cybershop.window.Complects);


