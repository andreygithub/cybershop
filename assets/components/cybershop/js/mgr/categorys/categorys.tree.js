/**
 * Generates a Tree for managing the Top Menu
 *
 * @class MODx.tree.Menu
 * @extends MODx.tree.Tree
 * @param {Object} config An object of options.
 * @xtype modx-tree-menu
 */
Cybershop.tree.Categorys = function(config) {
    config = config || {};
    config.id = Ext.id();
    Ext.applyIf(config,{
        id: config.id
        ,root_id: '0'
        ,root_name: _('cs_categorys')
        ,rootVisible: true
        ,expandFirst: true
        ,enableDrag: false
        ,enableDrop: false
        ,url: Cybershop.config.connectorUrl
        ,action: 'mgr/categorys/getnodes'
        ,primaryKey: 'id'
        ,useDefaultToolbar: true
        ,ddGroup: 'cybershop-categorys'
        ,tbar: [{
            text: _('cs_element_create')
            ,handler: this.createNewElement
            ,scope: this
        }]
    });
    Cybershop.tree.Categorys.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.tree.Categorys, MODx.tree.Tree, {
    windows: {}
	
    ,createNewElement: function(n,e) {
        var r = {};
        if (this.cm && this.cm.activeNode && this.cm.activeNode.attributes && this.cm.activeNode.attributes.data) {
            r['parent'] = this.cm.activeNode.attributes.data.id;
        }
        if (!this.windows.newelement) {
            this.windows.newelement = MODx.load({
                xtype: 'cybershop-window-categorys'
                ,record: r
                ,title: _('cs_create_update')
                ,baseParams: {action: 'mgr/categorys/create'}
                ,listeners: {
                    'success': {fn:function(r) { this.refresh(); },scope:this}
                }
            });
        }
        this.windows.newelement.reset();
        this.windows.newelement.setValues(r);
        this.windows.newelement.show(e.target);
    }
	
    ,updateElement: function(n,e) {
        var r = this.cm.activeNode.attributes.data;
        Ext.apply(r,{
//            action_id: r.action
//            ,new_text: r.text
        });
        if (!this.windows.element) {
            this.windows.element = MODx.load({
                xtype: 'cybershop-window-categorys'
                ,title: _('cs_element_update')
                ,record: r
                ,listeners: {
                    'success': {fn:function(r) { this.refresh(); },scope:this}
                }
            });
        }

        this.windows.element.setValues(r);
        this.windows.element.show(e.target);
    }
	
    ,removeElement: function(n,e) {
        MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/categorys/remove'
                ,id: this.cm.activeNode.attributes.pk
            }
            ,listeners: {
                'success':{fn:this.refresh,scope:this}
            }
        });
    }

    ,getMenu: function(n,e) {
        var m = [];
        switch (n.attributes.type) {
            case 'branch':
                m.push({
                    text: _('cs_element_open')
                    ,handler: this.updateElement
                });
                m.push({
                    text: _('cs_element_create')
                    ,handler: this.createNewElement
                });
                m.push({
                    text: _('cs_element_remove')
                    ,handler: this.removeElement
                });
                break;
            case 'leaf':
                m.push({
                    text: _('cs_element_open')
                    ,handler: this.updateElement
                });
                m.push({
                    text: _('cs_element_remove')
                    ,handler: this.removeElement
                });
                break;
            default:
                m.push({
                    text: _('cs_element_create')
                    ,handler: this.createNewElement
                });
                break;
        }
        return m;
    }
});
Ext.reg('cybershop-tree-categorys',Cybershop.tree.Categorys);

