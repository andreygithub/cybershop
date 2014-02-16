Cybershop.combo.Browser = function(config) {
    config = config || {};
    Ext.applyIf(config,{
       width: 300
       ,triggerAction: 'all'
       ,source: config.source || 1
    });
    Cybershop.combo.Browser.superclass.constructor.call(this,config);
    this.config = config;
};
Ext.extend(Cybershop.combo.Browser,Ext.form.TriggerField,{
    browser: null
    
    ,onTriggerClick : function(btn){
        if (this.disabled){
            return false;
        }

        if (this.browser === null) {
            this.browser = MODx.load({
                xtype: 'cybershop-browser'
                ,id: Ext.id()
                ,multiple: true
                ,source: this.config.source || 1
                ,hideFiles: this.config.hideFiles || false
                ,rootVisible: this.config.rootVisible || false
                ,allowedFileTypes: this.config.allowedFileTypes || ''
                ,wctx: this.config.wctx || 'web'
                ,openTo: this.config.openTo || this.config.rootId 
                ,rootId: this.config.rootId || '/'
                ,hideSourceCombo: this.config.hideSourceCombo || false
                ,listeners: {
                    'select': {fn: function(data) {
                        this.setValue(data.relativeUrl);
                        this.fireEvent('select',data);
                    },scope:this}
                }
            });
        }
        this.browser.rootId = this.config.rootId;
        this.browser.openTo = this.config.rootId;
        this.browser.config.rootId = this.config.rootId;
        this.browser.config.openTo = this.config.rootId;
        this.browser.show(btn);
        return true;
    }
    
    ,onDestroy: function(){
        Cybershop.combo.Browser.superclass.onDestroy.call(this);
    }
});
Ext.reg('cybershop-combo-browser',Cybershop.combo.Browser);

Ext.namespace('Cybershop.browser');

Cybershop.Browser = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        onSelect: function(data) {}
        ,scope: this
        ,source: config.source || 1
        ,cls: 'cybershop-browser'
    });
    Cybershop.Browser.superclass.constructor.call(this,config);
    this.config = config;
    
    this.win = new Cybershop.browser.Window(config);
    this.win.reset();
};
Ext.extend(Cybershop.Browser,Ext.Component,{
    show: function(el) { if (this.win) { this.win.load(); this.win.show(el); } }
    ,hide: function() { if (this.win) { this.win.hide(); } }

    ,setSource: function(source) {
        this.config.source = source;
        this.win.view.config.baseParams.source = source;
    }
    
});
Ext.reg('cybershop-browser',Cybershop.Browser);

Cybershop.browser.Window = function(config) {
    config = config || {};
    this.ident = Ext.id();
    this.view = MODx.load({
        xtype: 'cybershop-browser-view'
        ,onSelect: {fn: this.onSelect, scope: this}
        ,source: config.source || MODx.config.default_media_source
        ,allowedFileTypes: config.allowedFileTypes || ''
        ,wctx: config.wctx || 'web'
        ,openTo: config.openTo || ''
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
            //,width: 635
            ,border: false
            ,items: this.view
            ,tbar: this.getToolbar()
        },{
            id: this.ident+'-img-detail-panel'
            ,cls: 'cybershop-pb-details-ct'
            ,region: 'east'
            ,split: true
            ,border: false
            ,width: 250
        }]
        ,buttons: [{
            id: this.ident+'-upload-btn'
            ,text: _('upload')
            ,handler: this.uploadFiles
            ,scope: this
        },{         
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
    Cybershop.browser.Window.superclass.constructor.call(this,config);
    this.config = config;
    this.addEvents({
        'select': true
    });
};
Ext.extend(Cybershop.browser.Window,Ext.Window,{
    returnEl: null
    
    ,filter : function(){
        var filter = Ext.getCmp(this.ident+'filter');
        this.view.store.filter('name', filter.getValue(),true);
        this.view.select(0);
    }
    
    ,setReturn: function(el) {
        this.returnEl = el;
    }
    
    ,load: function(dir) {
        dir = dir || (Ext.isEmpty(this.config.openTo) ? '' : this.config.openTo);
        this.view.run({
            dir: dir
            ,source: this.config.source
            ,allowedFileTypes: this.config.allowedFileTypes || ''
            ,wctx: this.config.wctx || 'web'
        });
        this.sortImages();
    }
    
    ,sortImages : function(){
        var v = Ext.getCmp(this.ident+'sortSelect').getValue();
        this.view.store.sort(v, v == 'name' ? 'asc' : 'desc');
        this.view.select(0);
    }
    
    ,reset: function(){
        if(this.rendered){
            Ext.getCmp(this.ident+'filter').reset();
            this.view.getEl().dom.scrollTop = 0;
        }
        this.view.store.clearFilter();
        this.view.select(0);
    }
    
    ,getToolbar: function() {
        return ['-', {
            text: _('filter')+':'
            ,xtype: 'label'
        }, '-', {
            xtype: 'textfield'
            ,id: this.ident+'filter'
            ,selectOnFocus: true
            ,width: 100
            ,listeners: {
                'render': {fn:function(){
                    Ext.getCmp(this.ident+'filter').getEl().on('keyup', function(){
                        this.filter();
                    }, this, {buffer:500});
                }, scope:this}
            }
        }, '-', {
            text: _('sort_by')+':'
            ,xtype: 'label'
        }, '-', {
            id: this.ident+'sortSelect'
            ,xtype: 'combo'
            ,typeAhead: true
            ,triggerAction: 'all'
            ,width: 100
            ,editable: false
            ,mode: 'local'
            ,displayField: 'desc'
            ,valueField: 'name'
            ,lazyInit: false
            ,value: MODx.config.modx_browser_default_sort || 'name'
            ,store: new Ext.data.SimpleStore({
                fields: ['name', 'desc'],
                data : [['name',_('name')],['size',_('file_size')],['lastmod',_('last_modified')]]
            })
            ,listeners: {
                'select': {fn:this.sortImages, scope:this}
            }
        }];
    }
    
    ,onSelect: function(data) {
        var selNode = this.view.getSelectedNodes()[0];
        var callback = this.config.onSelect || this.onSelectHandler;
        var lookup = this.view.lookup;
        var scope = this.config.scope;
        this.hide(this.config.animEl || null,function(){
            if(selNode && callback){
                var data = lookup[selNode.id];
                Ext.callback(callback,scope || this,[data]);
                this.fireEvent('select',data);
            }
        },scope);
    }
   ,uploadFiles: function(btn,e) {
        if (!this.uploader) {
            this.uploader = new Ext.ux.UploadDialog.Dialog({
                url: MODx.config.connectors_url+'browser/file.php'
                ,base_params: {
                    action: 'upload'
                    ,wctx: MODx.ctx || ''
                    ,source: this.source
                }
                ,reset_on_hide: true
                ,width: 550
                ,cls: 'ext-ux-uploaddialog-dialog modx-upload-window'
            });
            this.uploader.on('show',this.beforeUpload,this);
            this.uploader.on('uploadsuccess',this.uploadSuccess,this);
            this.uploader.on('uploaderror',this.uploadError,this);
            this.uploader.on('uploadfailed',this.uploadFailed,this);
        }
        this.uploader.base_params.source = this.source;
        this.uploader.show(btn);
    }
    ,uploadError: function(dlg,file,data,rec) {}
    ,uploadFailed: function(dlg,file,rec) {}
    
    ,uploadSuccess:function() {
        this.load();
        this.fireEvent('afterUpload');
    }    
    ,beforeUpload: function() {
        var path = this.config.rootId;

        this.uploader.setBaseParams({
            action: 'upload'
            ,path: path
            ,wctx: MODx.ctx || ''
            ,source: this.source
        });
        this.fireEvent('beforeUpload');
    }
    ,onSelectHandler: function(data) {
        Ext.get(this.returnEl).dom.value = unescape(data.url);
    }
});
Ext.reg('cybershop-browser-window',Cybershop.browser.Window);

Cybershop.browser.View = function(config) {
    config = config || {};
    this.ident = config.ident+'-view' || 'cybershop-browser-'+Ext.id()+'-view';
    
    this._initTemplates();
    Ext.applyIf(config,{
        url: MODx.config.connectors_url+'browser/directory.php'
        ,id: this.ident
        ,fields: [
            'name','cls','url','relativeUrl','fullRelativeUrl','image','image_width','image_height','thumb','thumb_width','thumb_height','pathname','ext','disabled'
            ,{name:'size', type: 'float'}
            ,{name:'lastmod', type:'date', dateFormat:'timestamp'}
            ,'menu'
        ]
        ,baseParams: { 
            action: 'getFiles'
            ,prependPath: config.prependPath || null
            ,prependUrl: config.prependUrl || null
            ,source: config.source || 1
            ,allowedFileTypes: config.allowedFileTypes || ''
            ,wctx: config.wctx || 'web'
            ,dir: config.openTo || ''
        }
        ,sortInfo: {
            field: MODx.config.modx_browser_default_sort || 'name'
            ,direction: 'ASC'
        }
        ,tpl: this.templates.thumb
        ,listeners: {
            'selectionchange': {fn:this.showDetails, scope:this, buffer:100}
            ,'dblclick': config.onSelect || {fn:Ext.emptyFn,scope:this}
        }
        ,prepareData: this.formatData.createDelegate(this)
    });
    Cybershop.browser.View.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop.browser.View,MODx.DataView,{
    templates: {}
    
    ,removeFile: function(item,e) {
        var node = this.cm.activeNode;
        var data = this.lookup[node.id];
        MODx.msg.confirm({
            text: _('file_remove_confirm')
            ,url: MODx.config.connectors_url+'browser/file.php'
            ,params: {
                action: 'remove'
                ,file: data.url
                ,source: this.config.source
                ,wctx: this.config.wctx || 'web'
            }
            ,listeners: {
                'success': {fn:function(r) {
                    this.run();
                },scope:this}
            }
        });
    }
    
    ,run: function(p) {
        p = p || {};
        if (p.dir) { this.dir = p.dir; }
        Ext.applyIf(p,{
            action: 'getFiles'
            ,dir: this.dir
            ,source: this.config.source || Cybershop.config.default_media_source
        });
        this.store.load({
            params: p
            ,callback: function() { this.refresh(); }
            ,scope: this
        });
    }
    
    ,showDetails : function(){
        var selNode = this.getSelectedNodes();
        var detailEl = Ext.getCmp(this.config.ident+'-img-detail-panel').body;
        if(selNode && selNode.length > 0){
            selNode = selNode[0];
            Ext.getCmp(this.ident+'-ok-btn').enable();
            var data = this.lookup[selNode.id];
            detailEl.hide();
            this.templates.details.overwrite(detailEl, data);
            detailEl.slideIn('l', {stopFx:true,duration:'.2'});
        }else{
            Ext.getCmp(this.config.ident+'-ok-btn').disable();
            detailEl.update('');
        }
    }
    ,formatData: function(data) {
        var formatSize = function(size){
            if(size < 1024) {
                return size + " bytes";
            } else {
                return (Math.round(((size*10) / 1024))/10) + " KB";
            }
        };
        data.shortName = Ext.util.Format.ellipsis(data.name,18);
        data.sizeString = data.size != 0 ? formatSize(data.size) : 0;
        data.dateString = !Ext.isEmpty(data.lastmod) ? new Date(data.lastmod).format("m/d/Y g:i a") : 0;
        this.lookup[data.name] = data;
        return data;
    }
    ,_initTemplates: function() {
        this.templates.thumb = new Ext.XTemplate(
            '<tpl for=".">'
                ,'<div class="modx-pb-thumb-wrap" id="{name}" title="{name}">'
                ,'<div class="modx-pb-thumb"><img src="{thumb}" title="{name}" /></div>'
                ,'<span>{shortName}</span></div>'
            ,'</tpl>'
        );
        this.templates.thumb.compile();
        
        this.templates.details = new Ext.XTemplate(
            '<div class="details">'
            ,'<tpl for=".">'
                ,'<div class="modx-pb-detail-thumb">' 
                    ,'<img src="{thumb}" alt="" onclick="Ext.getCmp(\''+this.ident+'\').showFullView(\'{name}\',\''+this.ident+'\'); return false;" />'
                ,'</div>'
                ,'<div class="modx-pb-details-info">'
                ,'<b>'+_('file_name')+':</b>'
                ,'<span>{name}</span>'
                ,'<tpl if="this.isEmpty(sizeString) == false">'
                    ,'<b>'+_('file_size')+':</b>'
                    ,'<span>{sizeString}</span>'
                ,'</tpl>'
                ,'<tpl if="this.isEmpty(dateString) == false">'
                    ,'<b>'+_('last_modified')+':</b>'
                    ,'<span>{dateString}</span></div>'
                ,'</tpl>'
            ,'</tpl>'
            ,'</div>'
        ,{
            isEmpty: function (v) {
                return (v == '' || v == null || v == undefined || v === 0);
            }
        });
        this.templates.details.compile(); 
    }
    ,showFullView: function(name,ident) {
        var data = this.lookup[name];
        if (!data) return;
        
        if (!this.fvWin) {
            this.fvWin = new Ext.Window({
                layout:'fit'
                ,width: 600
                ,height: 450
                ,closeAction:'hide'
                ,plain: true
                ,items: [{
                    id: this.ident+'cybershop-view-item-full'
                    ,cls: 'cybershop-pb-fullview'
                    ,html: ''
                }]
                ,buttons: [{
                    text: _('close')
                    ,handler: function() { this.fvWin.hide(); }
                    ,scope: this
                }]
            });
        }
        this.fvWin.show();
        var w = data.image_width < 250 ? 250 : data.image_width;
        var h = data.image_height < 200 ? 200 : data.image_height;
        this.fvWin.setSize(w,h);
        this.fvWin.center();
        this.fvWin.setTitle(data.name);
        Ext.get(this.ident+'cybershop-view-item-full').update('<img src="'+data.image+'" alt="" class="modx-pb-fullview-img" onclick="Ext.getCmp(\''+ident+'\').fvWin.hide();" />');
    }
});
Ext.reg('cybershop-browser-view',Cybershop.browser.View);
