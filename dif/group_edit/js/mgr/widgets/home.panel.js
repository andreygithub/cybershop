
/**
 * Главная страница компонента
 *
 * @class grEdit.grid.catalog
 * @extends Ext.grid
 * @param {Object} config An object of options.
 * @xtype group_edit-panel-home
 */

grEdit.page.Cmp = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        formpanel: 'group_edit-panel-home'
        ,buttons: [{
            text: _('save')
            ,id: 'action-save'
            ,disabled: true
            ,handler: function(){
                Ext.getCmp('group_edit-panel-home-cmp').saveResource();
            }
        }]
        ,components: [{
            xtype: 'group_edit-panel-home'
        }]
    });
    grEdit.page.Cmp.superclass.constructor.call(this,config);
};
Ext.extend(grEdit.page.Cmp,MODx.Component);
Ext.reg('group_edit-cmp',grEdit.page.Cmp);



grEdit.panel.Home = function(config){
    config = config || {};
    Ext.apply(config,{
        id: 'group_edit-panel-home-cmp'
        ,border: false
        ,baseCls: 'modx-formpanel container'
        ,items: [{
            html: '<h2>'+grEdit.config.modName+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,id: 'group_edit-panel-home-tabs-cmp'
            ,bodyStyle: 'padding: 10px'
            ,defaults: {border: false ,autoHeight: true}
            ,border: true
            ,tabPosition: 'top'
            ,activeTab: 0
            ,autoDestroy: true
            ,stateful: false
            ,stateId: 'group_edit-home-tabpanel'
            ,stateEvents: ['tabchange']
            ,getState:function() {
                return {activeTab:this.items.indexOf(this.getActiveTab())};
            }
            //Список разделов и ресурсов
            ,items: [{
                title: _('group_edit.list')
                ,defaults: { autoHeight: true }
                ,xtype: 'group_edit-grid-catalog'
                ,id: 'group_edit-grid-catalog-cmp'
            }]
            ,listeners: {
                tabchange: function(root,tab){
                    if(Ext.getCmp('action-save')!=null){
                        if(tab.id!='group_edit-grid-catalog-cmp') Ext.getCmp('action-save').enable();
                        else Ext.getCmp('action-save').disable();
                    }
                }
//                ,beforeclose: function(panel){
//                    console.log(panel);
//                }
            }
        }]
        ,listeners: {
            afterrender: function(panel){
                
            }
        }
    });
    grEdit.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(grEdit.panel.Home,MODx.Panel,{
    
    saveResource: function(button,event,callback){
        
        var activeTab = Ext.getCmp('group_edit-panel-home-tabs-cmp').getActiveTab();
        var form = Ext.query('#'+activeTab.getId()+' div.x-panel');
        var form_id = Ext.get(form[0]).getAttribute('id');
        var cmp = Ext.getCmp(form_id);
        
        cmp.container.mask(_('loading'),'x-mask-loading');
        
        var form_data = cmp.getForm().getValues();
        
        //создание нового ресурса
        if(activeTab.title==_('new')){
            
            form_data.action = "create";
            delete form_data['create-resource-token'];
            grEdit.config.new_res++;
            if(form_data.pagetitle==''){
                form_data.pagetitle = _('new')+grEdit.config.new_res;//grEdit.config.new_res;
                cmp.getForm().findField('pagetitle').setRawValue(_('new')+grEdit.config.new_res);
            }
            
        //обновление ресурса
        }else{
            form_data.action = "update";
        }
        
        //скрываем документ в дереве документов, если нужно
        if(form_data.parent == grEdit.config.topParentId){
            form_data.show_in_tree = grEdit.config.hide_children_in_tree ? 0 : 1;
        }else{
            form_data.show_in_tree = 1;
        }
        
        Ext.Ajax.request({
            url: MODx.config.connectors_url+'resource/index.php'
            ,params: form_data
            ,method: 'POST'
            ,success: function(response, options){
                
                var resource = Ext.util.JSON.decode(response.responseText);
                var res_id = resource.object.id;
                var id_field = Ext.query('#'+form_id+' input[name=id]');
                id_field[0].value = res_id;
                
                cmp.container.unmask();
                Ext.getCmp('group_edit-grid-catalog-cmp').refresh();
                
                activeTab.setTitle(form_data.pagetitle);
                cmp.ident = res_id;
                
                //RTE
                var content_field = Ext.query('#'+form[0].id+' textarea[name=ta]');
                var content_field_id = content_field[0].id;
                if(typeof(tinymce)!='undefined'){
                    if(form_data.richtext==1 && Ext.get(content_field_id+'_ifr')==null){
                        new tinymce.Editor(content_field_id, Tiny.config).render();
                    }else if(form_data.richtext==0 && Ext.get(content_field_id+'_ifr')!=null){
                        tinymce.get(content_field_id).remove(); 
                    }
                }
                
                if(typeof(callback)=='function') callback(res_id);

            }
            ,failure: function(frm,a) {
                if (this.fireEvent('failure',{f:frm,a:a})) {
                    MODx.form.Handler.errorExt(a.result,frm);
                }
            }
        });
        
    }
    
});
Ext.reg('group_edit-panel-home',grEdit.panel.Home);


