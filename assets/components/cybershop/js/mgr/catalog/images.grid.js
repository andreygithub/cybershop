Cybershop.grid.Images = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/catalog/catalogimagetable/getList'}
        ,save_action: 'mgr/catalog/catalogimagetable/updateFromGrid' 
        ,fields: ['id','name','catalog'
                  ,'fulltext','image']
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
            ,width: 50
        },{
            header: _('cs_image')
            ,dataIndex: 'image'
            ,sortable: true
            ,renderer: this.renderItemImage
            ,width: 50
        },{
            header: _('cs_name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 400
        }]

	,tbar: 
            [{
                text: _('cs_element_create')
                ,handler: this.createNewElement
            }]

       
     });
    Cybershop.grid.Images.superclass.constructor.call(this,config);

};

Ext.extend(Cybershop.grid.Images,MODx.grid.Grid,{
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
                action: 'mgr/catalog/catalogimagetable/remove'
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
                        xtype: 'cybershop-window-images'
                        ,title: _('cs_element_create')
                        ,baseParams: {action: 'mgr/catalog/catalogimagetable/create'}
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
                    xtype: 'cybershop-window-images'
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
            var out = image_path!='' ? '<img src="'+image_path+'" height="40" alt="'+v+'" title="'+v+'" />' : '';
            return out;
        }
});
Ext.reg('cybershop-grid-images',Cybershop.grid.Images);

Cybershop.window.Images = function(config) {
    config = config || {};
    config.id = Ext.id();
    Ext.applyIf(config,{
        title: _('cs_element_update')
        ,id: config.id
        ,url: Cybershop.config.connectorUrl
        ,baseParams: {
            action: 'mgr/catalog/catalogimagetable/update'
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
            xtype: 'textfield'
            ,fieldLabel: _('cs_name')
            ,name: 'name'
            ,anchor: '99%'
        },{
            xtype: 'cybershop-combo-browser'
            ,id: config.id+'-image'
            ,fieldLabel: _('cs_image')
            ,name: 'image'
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

    });
    
    Cybershop.window.Images.superclass.constructor.call(this,config);
        
    this.on('show',function() {
        var filter = this.config.filterId;
        Ext.getCmp(config.id + '-catalog').setValue(filter);
        Ext.getCmp(config.id+'-image').config.rootId = Cybershop.config.catalog_image_path + 'catalog/' + filter + '/'
    },this);
};

Ext.extend(Cybershop.window.Images,MODx.Window);
Ext.reg('cybershop-window-images',Cybershop.window.Images);


