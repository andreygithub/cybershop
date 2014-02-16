Cybershop.grid.Categorys = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'cybershop-grid-categorys-cmp'
        ,url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/categorys/getList', a: Cybershop.request.a, type: Cybershop.request.type, categoryId: Cybershop.config.parentId, parentId: 0, template: 0}
        ,save_action: 'mgr/categorys/updateFromGrid'
        ,fields: ['id','parent','isfolder','name','alias','sort_position','description','introtext','fulltext','image','ceo_data','ceo_key','ceo_description']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '99%'
        ,autoExpandColumn: 'name'
        ,columns: [{
            header: _('cs_id')
            ,dataIndex: 'isfolder'
            ,sortable: true
            ,renderer: this.renderIsFolder
            ,width: 10
        },{
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
            ,renderer: this.renderItem
            ,width: 100
        },{
            header: _('cs_description')
            ,dataIndex: 'description'
            ,sortable: false
            ,width: 350
        }]
	,tbar: [{
            text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-categorys' 
                        ,baseParams: {action: 'mgr/categorys/create'}
                        ,blankValues: true }
        },'-',{
            text: Cybershop.config.modName
            ,id: 'cybershop-gotoup_level'
            ,iconCls: 'cybershop_toplevel'
            ,tooltip: _('cybershopt.to_up_level')
            ,handler: this.goToUpLevel
            ,hidden: true
        }]
     });
    Cybershop.grid.Categorys.superclass.constructor.call(this,config)
};

Ext.extend(Cybershop.grid.Categorys,MODx.grid.Grid,{
    getMenu: function() {
        return [{
	     text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-categorys' 
                        ,baseParams: {action: 'mgr/categorys/create'}
                        ,blankValues: true }
        },{
            text: _('cs_element_open')
            ,handler: this.updateElement
        },{
            text: _('cs_element_remove')
            ,handler: this.removeElement
        }];
    }
    ,updateElement: function(btn,e) {
        if (!this.updateCategorysWindow) {
            this.updateCategorysWindow = MODx.load({
                xtype: 'cybershop-window-categorys'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateCategorysWindow.setValues(this.menu.record);
        this.updateCategorysWindow.show(e.target);
    }

    ,removeElement: function() {
        MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/categorys/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
        
    }
    ,renderItem: function(v,md,rec){
        var fields_keys = Object.keys(grEdit.config.fields);
        var out = '<a href="#" class="'+rec.data.itemClass+'" onclick="Ext.getCmp(\'group_edit-grid-catalog-cmp\').openCategory('+rec.data.id+','+rec.data.parent+','+rec.data.isfolder+');return false;">'
            +rec.data[fields_keys[0]]
            +'</a>';
        return out;
    }
    ,renderIsFolder: function(v,md,rec){
        var out = '<a href="#" class="x-tree-node-icon" onclick="Ext.getCmp(\'cybershop-grid-categorys-cmp\').openCategory('+rec.data.id+','+rec.data.parent+','+rec.data.isfolder+');return false;">'
            +rec.data[fields_keys[0]]
            +'</a>';
        return out;
    }
    ,renderItemImage: function(v,md,rec) {
        var image_path = v!='' ? MODx.config.base_url+'connectors/system/phpthumb.php?w=40&h=40&src='+MODx.config.base_url+v : '';
        var out = image_path!='' ? '<img src="'+image_path+'" width="40" height="40" alt="'+v+'" title="'+v+'" />' : '';
        return out;
    }
});
Ext.reg('cybershop-grid-categorys',Cybershop.grid.Categorys);

