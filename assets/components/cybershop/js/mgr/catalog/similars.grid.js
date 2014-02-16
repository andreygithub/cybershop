Cybershop.grid.Similars = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/catalog/catalogsimilartable/getList'}
        ,save_action: 'mgr/catalog/catalogsimilartable/updateFromGrid' 
        ,fields: ['id','similarelement','catalog'
                  ,'similarelement_name','similarelement_description'
                  ,'similarelement_image']
        ,paging: true
        ,pageSize: 5
        ,autosave: true
        ,remoteSort: true
        ,anchor: '99%'
        ,autoExpandColumn: 'similarelement_name'
        ,columns: [{
            header: _('cs_id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 50
        },{
            header: _('cs_image')
            ,dataIndex: 'similarelement_image'
            ,sortable: true
            ,renderer: this.renderItemImage
            ,width: 50
        },{
            header: _('cs_name')
            ,dataIndex: 'similarelement_name'
            ,sortable: true
            ,width: 200
        },{
            header: _('cs_description')
            ,dataIndex: 'similarelement_description'
            ,sortable: true
            ,width: 200
        }]

	,tbar: 
            [{
                text: _('cs_element_create')
                ,handler: this.createNewElement
            }]

       
     });
    Cybershop.grid.Similars.superclass.constructor.call(this,config);

};

Ext.extend(Cybershop.grid.Similars,MODx.grid.Grid,{
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
                action: 'mgr/catalog/catalogsimilartable/remove'
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
                        xtype: 'cybershop-window-similars'
                        ,title: _('cs_element_create')
                        ,baseParams: {action: 'mgr/catalog/catalogsimilartable/create'}
                        ,listeners: {
                            'success': {fn:this.refresh,scope:this}
                            }
                    });
            };
            this.createElementWindow.config.blankValues = true;
            this.createElementWindow.config.winid = this.config.id;
            this.createElementWindow.show(); 
            this.createElementWindow.fp.getForm().items.itemAt(1).setValue(this.config.filterId);
                  
        }
        ,updateElement: function(n,e) {
            if (!this.updateWindow) {
                this.updateWindow = MODx.load({
                    xtype: 'cybershop-window-similars'
                    ,record: this.menu.record
                    ,listeners: {
                        'success': {fn:this.refresh,scope:this}
                    }
                });
            }
            this.updateWindow.setValues(this.menu.record);
            this.updateWindow.show(e.target);
        }
        ,renderItemImage: function(v,md,rec) {
            var image_path = v!='' ? MODx.config.base_url+'connectors/system/phpthumb.php?w=40&h=40&src='+MODx.config.base_url+v : '';
            var out = image_path!='' ? '<img src="'+image_path+'" width="40" height="40" alt="'+v+'" title="'+v+'" />' : '';
            return out;
        }
});
Ext.reg('cybershop-grid-similars',Cybershop.grid.Similars);

Cybershop.window.Similars = function(config) {
    config = config || {};
    config.id = Ext.id();
    Ext.applyIf(config,{
        title: _('cs_element_update')
        ,id: config.id
        ,url: Cybershop.config.connectorUrl
        ,baseParams: {
            action: 'mgr/catalog/catalogsimilartable/update'
        }
        ,width: 700  
        ,minWidth:700 
        ,fields:
        [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'hidden'
            ,name: 'catalog'
        },{
             xtype: 'cybershop-combo-catalog'
             ,id: config.id+'-combo-catalog'
             ,fieldLabel: _('cs_category')
             ,name: 'similarelement'
             ,anchor: '99%'
        }]

    });
    Cybershop.window.Similars.superclass.constructor.call(this,config);
};

Ext.extend(Cybershop.window.Similars,MODx.Window);
Ext.reg('cybershop-window-similars',Cybershop.window.Similars);


