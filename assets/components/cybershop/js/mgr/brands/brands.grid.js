Cybershop.grid.Brands = function(config) {
    config = config || {};
    config.id = Ext.id()
    Ext.applyIf(config,{
        id: config.id
        ,url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/brands/getList' }
        ,save_action: 'mgr/brands/updateFromGrid'
        ,fields: ['id','name','description','introtext','fulltext','parent','isfolder','sort_position','image','url','ceo_data','ceo_key','ceo_description']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '100%'
        ,autoExpandColumn: 'name'
        ,sm: this.sm
        ,selectOnFocus: true
        ,columns: [{
            header: _('cs_id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 60
        },{
            header: _('cs_image')
            ,dataIndex: 'image'
            ,sortable: true
            ,renderer: this.renderImg
            ,width: 100
        },{
            header: _('cs_name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 100
        },{
            header: _('cs_description')
            ,dataIndex: 'description'
            ,sortable: true
            ,width: 350
        }]
	,tbar: [{
            text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-brands' 
                        ,title: _('cs_element_create')
                        ,baseParams: {action: 'mgr/brands/create'}
                        ,blankValues: true }
        }]
        ,listeners: {
                rowDblClick: function(grid, rowIndex, e) {
                        var row = grid.store.getAt(rowIndex);
                        this.updateElement(grid, e, row);
                }
            }
    });
    Cybershop.grid.Brands.superclass.constructor.call(this,config)
};
Ext.extend(Cybershop.grid.Brands,MODx.grid.Grid,{
    getMenu: function() {
        return [{
	     text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-brands' 
                        ,title: _('cs_element_create')
                        ,baseParams: {action: 'mgr/brands/create'}
                        ,blankValues: true }
        },{
            text: _('cs_element_update')
            ,handler: this.updateElement
        },{
            text: _('cs_element_remove')
            ,handler: this.removeElement
        }];
    }
    ,updateElement: function(btn,e,row) {
        
        if (typeof(row) != 'undefined') {this.menu.record = row.data;}
        
        if (!this.updateBrandsWindow) {
            this.updateBrandsWindow = MODx.load({
                xtype: 'cybershop-window-brands'
                ,title: _('cs_element_update')
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateBrandsWindow.setValues(this.menu.record);
        this.updateBrandsWindow.show(e.target);
    }

    ,removeElement: function() {
        MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/brands/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    ,renderImg: function(v,md,rec) {
        var image_path = v!='' ? MODx.config.base_url+'connectors/system/phpthumb.php?w=40&h=40&src='+MODx.config.base_url+v : '';
        var out = image_path!='' ? '<img src="'+image_path+'" width="40" height="40" alt="'+v+'" title="'+v+'" />' : '';
        return out;
    }
});
Ext.reg('cybershop-grid-brands',Cybershop.grid.Brands);

