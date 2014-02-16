Cybershop.combo.Catalog = function(config) {
    config = config || {};
    Ext.applyIf(config,{
       width: 800
       ,triggerAction: 'all'
    });
    Cybershop.combo.Catalog.superclass.constructor.call(this,config);
    this.config = config;
};

Ext.extend(Cybershop.combo.Catalog,Ext.form.TriggerField,{
    browser_catalog: null
   ,onTriggerClick : function(btn){
        if (this.disabled){
            return false;
        }

        if (this.browser_catalog === null) {
            this.browser_catalog = MODx.load({
                xtype: 'cybershop-browser-catalog'
                ,id: Ext.id()
                ,listeners: {
                    'select': {fn: function(data) {
                        this.setValue(data);
                        this.fireEvent('select',data);
                    },scope:this}
                }
            });
        }
        this.browser_catalog.show(btn);
        return true;
    }
    
    ,onDestroy: function(){
        Cybershop.combo.Catalog.superclass.onDestroy.call(this);
    }
});
Ext.reg('cybershop-combo-catalog',Cybershop.combo.Catalog);

Ext.namespace('Cybershop.browser.Catalog');

Cybershop.browser.Catalog = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        onSelect: function(data) {}
        ,scope: this
        ,cls: 'cybershop-browser-catalog'
    });
    Cybershop.browser.Catalog.superclass.constructor.call(this,config);
    this.config = config;
    
    this.win = new Cybershop.browser.Catalog.Window(config);
//    this.win.reset();
};

Ext.extend(Cybershop.browser.Catalog,Ext.Component,{
    show: function(el) { if (this.win) { this.win.show(el); } }
    ,hide: function() { if (this.win) { this.win.hide(); } }
});
Ext.reg('cybershop-browser-catalog',Cybershop.browser.Catalog);

Cybershop.browser.Catalog.Window = function(config) {
    config = config || {};
    this.ident = Ext.id();
    this.view = MODx.load({
        xtype: 'cybershop-browser-grid-catalog'
        ,onSelect: {fn: this.onSelect, scope: this}
        ,ident: this.ident
        ,id: this.ident+'-view'
    });
  
    Ext.applyIf(config,{
        title: _('modx_browser')+' ('+(MODx.ctx ? MODx.ctx : 'web')+')'
        ,cls: 'cybershop-pb-win'
        ,layout: 'border'
        ,minWidth: 500
        ,minHeight: 300
        ,width: '90%'
        ,height: 500
        ,modal: false
        ,closeAction: 'hide'
        ,border: false
        ,items: [{
            id: this.ident+'-browser-view'
            ,cls: 'cybershop-pb-view-ct'
            ,region: 'center'
            ,autoScroll: true
            ,border: false
            ,items: this.view
        }]
        ,buttons: [{
            id: this.ident+'-cancel-btn'
            ,text: _('cancel')
            ,handler: this.hide
            ,scope: this
        },{
            id: this.ident+'-ok-btn'
            ,text: _('ok')
            ,handler: this.onSelect
            ,scope: this
        }]
        ,keys: {
            key: 27
            ,handler: this.hide
            ,scope: this
        }
    });
    Cybershop.browser.Catalog.Window.superclass.constructor.call(this,config);
    this.config = config;
    this.addEvents({
        'select': true
    });
};
Ext.extend(Cybershop.browser.Catalog.Window,Ext.Window,{
    returnEl: null

    ,onSelect: function(data) {
        var selElementID = this.view.getSelectedAsList();
        var callback = this.config.onSelect || this.onSelectHandler;
        var scope = this.config.scope;
        this.hide(this.config.animEl || null,function(){
            if(selElementID && callback){
                var data = selElementID;
                Ext.callback(callback,scope || this,[data]);
                this.fireEvent('select',data);
            }
        },scope);
    }

    ,onSelectHandler: function(data) {
        Ext.get(this.returnEl).dom.value = unescape(data.url);
    }
});
Ext.reg('cybershop-browser-catalog-window',Cybershop.browser.Catalog.Window);


Cybershop.browser.Catalog.Grid = function(config) {
    config = config || {};
    config.id = Ext.id();
    this.sm = new Ext.grid.CheckboxSelectionModel();
    
    Ext.applyIf(config,{
        id: config.id
        ,url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/catalog/getList' }
        ,save_action: 'mgr/catalog/updateFromGrid'
        ,fields: ['id','name','description','article'
                 ,'image','brand','brand_name','category'
                 ,'category_name','made_in','media'
                 ,'price1','price2','price3','weight'
                 ,'active','deleted','new'
                 ,'sellout','discount','onhomepage'
                 ,'url','ceo_data','ceo_key','ceo_description']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '99%'
        ,autoExpandColumn: 'name'
        ,sm: this.sm
        ,columns: [{
            header: _('cs_id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 60
        },{
            header: _('cs_active')
            ,dataIndex: 'active'
            ,sortable: true
            ,width: 30
            ,renderer: this.renderBoolean
            ,editor: {
                xtype: 'xcheckbox'
                        }
        },{
            header: _('cs_deleted')
            ,dataIndex: 'deleted'
            ,sortable: true
            ,width: 30
            ,renderer: this.renderBoolean
        },{
            header: _('cs_image')
            ,dataIndex: 'image'
            ,sortable: false
            ,renderer: this.renderImg
            ,width: 80
        },{
            header: _('cs_name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 200
            ,editor: new Ext.form.TextField({
                allowBlank: false
                })
        },{
            header: _('cs_description')
            ,dataIndex: 'description'
            ,sortable: false
            ,width: 200
            ,editor: new Ext.form.TextField({
                allowBlank: true
                })   
        },{
            header: _('cs_article')
            ,dataIndex: 'article'
            ,sortable: true
            ,width: 100
            ,editor: new Ext.form.TextField({
                allowBlank: true
            })            
        },{
	     header: _('cs_brand')
            ,dataIndex: 'brand_name'
            ,sortable: true
            ,width: 100
        },{
	     header: _('cs_category')
            ,dataIndex: 'category_name'
            ,sortable: true
            ,width: 100
        },{	
	     header: _('cs_price1')
            ,dataIndex: 'price1'
            ,sortable: true
            ,width: 60
            ,editor: new Ext.form.NumberField({
                decimalPrecision: 5
                ,allowBlank: true
                ,allowNegative: false
                ,maxValue: 100000
                })
        }]
       ,tbar: ['->',{
            xtype: 'modx-combo'
            ,id: config.id+'-combo-brands'
            ,name: 'brands'
            ,itemId: 'brands'
            ,emptyText: _('cs_selectElement')+'...'
            ,url: Cybershop.config.connectorUrl
            ,baseParams: {
                action: 'mgr/brands/getList'
                ,combo: true
                ,addall: true
            }
            ,width: 200
            ,listeners: {
                'select': {fn:this.filterBrands,scope:this}
            }
        },'-',{
            xtype: 'modx-combo'
            ,id: config.id+'-combo-categorys'
            ,name: 'categorys'
            ,itemId: 'categorys'
            ,emptyText: _('cs_selectElement')+'...'
            ,url: Cybershop.config.connectorUrl
            ,baseParams: {
                action: 'mgr/categorys/getList'
                ,combo: true
                ,addall: true
            }
  //          ,value: MODx.request['usergroup'] ? MODx.request['usergroup'] : ''
            ,width: 200
            ,pageSize: 30
            ,listeners: {
                'select': {fn:this.filterCategorys,scope:this}
            }
        },'-',{
            xtype: 'textfield'
            ,id: config.id+'-search-filter'
            ,emptyText: _('cs_search...')
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                },scope:this}
            }
         },{
            xtype: 'button'
            ,id: config.id+'-filter-clear'
            ,text: _('filter_clear')
            ,listeners: {
                'click': {fn: this.clearFilter, scope: this}
            }
        }]
    });
    Cybershop.browser.Catalog.Grid.superclass.constructor.call(this,config)
};
Ext.extend(Cybershop.browser.Catalog.Grid,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,filterBrands: function(cb,nv,ov) {
        this.getStore().baseParams.brand = Ext.isEmpty(nv) || Ext.isObject(nv) ? cb.getValue() : nv;
        this.getBottomToolbar().changePage(1);
        this.refresh();
        return true;
    }
    ,filterCategorys: function(cb,nv,ov) {
        this.getStore().baseParams.category = Ext.isEmpty(nv) || Ext.isObject(nv) ? cb.getValue() : nv;
        this.getBottomToolbar().changePage(1);
        this.refresh();
        return true;
    }
    ,clearFilter: function() {
    	this.getStore().baseParams = {
            action: 'mgr/catalog/getList'
    	};
        Ext.getCmp(this.config.id+'-search-filter').reset();
        Ext.getCmp(this.config.id+'-combo-categorys').reset();
        Ext.getCmp(this.config.id+'-combo-brands').reset();
    	this.getBottomToolbar().changePage(1);
        this.refresh();
    }

    ,renderImg: function(v,md,rec) {
        var image_path = v!='' ? MODx.config.base_url+'connectors/system/phpthumb.php?w=80&h=80&src='+MODx.config.base_url+v : '';
        var out = image_path!='' ? '<img src="'+image_path+'" width="80" height="80" alt="'+v+'" title="'+v+'" />' : '';
        return out;
   }
    ,renderBoolean: function(value) {
        if (value == 1) {return _('yes');}
        else {return _('no');}
    }
});
Ext.reg('cybershop-browser-grid-catalog',Cybershop.browser.Catalog.Grid);

