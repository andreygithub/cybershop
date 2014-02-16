
MODx.panel.Resource = function(config) {
    config = config || {record:{}};
    config.record = config.record || {};
    this.ident = config.ident || 'qcr'+Ext.id();
    Ext.applyIf(config,{
        url: MODx.config.connectors_url+'resource/index.php'
        ,baseParams: {}
        ,id: 'modx-panel-resource'+this.ident
        ,class_key: 'modDocument'
        ,resource: ''
        ,bodyStyle: ''
	,cls: 'container form-with-labels'
        ,defaults: { collapsible: false ,autoHeight: true }
        ,forceLayout: true
        ,items: this.getFields(config)
        ,fileUpload: true
        ,useLoadingMask: true
        ,listeners: {
            'setup': {fn:this.setup,scope:this}
            ,'success': {fn:this.success,scope:this}
            ,'failure': {fn:this.failure,scope:this}
            ,'beforeSubmit': {fn:this.beforeSubmit,scope:this}
        }
    });
    MODx.panel.Resource.superclass.constructor.call(this,config);
    var ta = Ext.get('ta');
    if (ta) { ta.on('keydown',this.fieldChangeEvent,this); }
    this.on('ready',this.onReady,this);
    var urio = Ext.getCmp('modx-resource-uri-override');
    if (urio) { urio.on('check',this.freezeUri); }
    //this.addEvents('tv-reset');
};

Ext.extend(MODx.panel.Resource,MODx.FormPanel,{
    initialized: false
    ,defaultClassKey: 'modDocument'
    ,classLexiconKey: 'document'
    ,rteElements: 'ta'
    ,rteLoaded: false
    ,setup: function() {
        
        if (!this.initialized) {
            this.getForm().setValues(this.config.record);
            var pcmb = this.getForm().findField('parent-cmb');
            if (pcmb && Ext.isEmpty(this.config.record.parent_pagetitle)) {
                pcmb.setValue('');
            } else if (pcmb) {
                pcmb.setValue(this.config.record.parent_pagetitle+' ('+this.config.record.parent+')');
            }
            if (!Ext.isEmpty(this.config.record.pagetitle)) {
                Ext.getCmp('modx-resource-header'+this.ident).getEl().update('<h2>'+Ext.util.Format.stripTags(this.config.record.pagetitle)+'</h2>');
            }
            if (!Ext.isEmpty(this.config.record.resourceGroups)) {
                var g = Ext.getCmp('modx-grid-resource-security');
                if (g && Ext.isEmpty(g.config.url)) {
                    var s = g.getStore();
                    if (s) { s.loadData(this.config.record.resourceGroups); }
                }
            }

            this.defaultClassKey = this.config.record.class_key || this.defaultClassKey;
            this.defaultValues = this.config.record || {};
            if ((this.config.record && this.config.record.richtext) || MODx.request.reload || MODx.request.activeSave == 1) {
                this.markDirty();
            }
        }
        
        if (MODx.config.use_editor && MODx.loadRTE) {
            var f = this.getForm().findField('richtext');
            if (f && f.getValue() == 1 && !this.rteLoaded) {
                MODx.loadRTE(this.rteElements);
                this.rteLoaded = true;
            } else if (f && f.getValue() == 0 && this.rteLoaded) {
                if (MODx.unloadRTE) {
                    MODx.unloadRTE('ta');
                }
                this.rteLoaded = false;
            }
        }

        this.fireEvent('ready');
        this.initialized = true;

        MODx.fireEvent('ready');
        MODx.sleep(4);
        if (MODx.afterTVLoad) { MODx.afterTVLoad(); }
        this.fireEvent('load');
        
    }
    
    ,beforeSubmit: function(o) {
        
    }
    ,success: function(o) {
        
    }
    ,failure: function(o) {
        if(this.getForm().baseParams.action == 'create') {
            Ext.getCmp('modx-abtn-save').enable();
        }
    }

    ,freezeUri: function(cb) {
        var uri = Ext.getCmp('modx-resource-uri');
        if (!uri) { return false; }
        if (cb.checked) {
            uri.show();
        } else {
            uri.hide();
        }
    }
    
    //Смена шаблона
    ,templateWarning: function() {
	
	var root = this;
	var itemId = this.ident;
	
        var t = Ext.getCmp('modx-resource-template'+this.ident);
        if (!t) { return false; }
        if(t.getValue() !== t.originalValue) {
            Ext.Msg.confirm(_('warning'), _('resource_change_template_confirm'), function(e) {
                if (e == 'yes') {
		    
		    var new_template = t.getValue();
                    
                    var activeTab = Ext.getCmp('group_edit-panel-home-tabs-cmp').getActiveTab();
                    var tabEl = activeTab.getEl();
                    
                    var tvPanel = Ext.get('modx-resource-tvs-div'+itemId);
                    tvPanel.mask(_('loading'),'x-mask-loading');
                    
                    Ext.getCmp('group_edit-panel-home-cmp').saveResource(null,null,function(res_id){
                        
                        MODx.Ajax.request({
                            url: grEdit.config.connector_url
                            ,params: {action: 'mgr/tvs', id: res_id}
                            ,listeners: {
                                'success': {fn:function(res) {
                                        
                                        tvPanel.unmask();
					tvPanel.set({id:'modx-resource-tvs-div'+res_id});
                                        //tvPanel.update(res.object.data);
					
					var tv_values = res.object.tv_values;
					var cmp = Ext.getCmp('group_edit-grid-catalog-cmp');
					cmp.ident = res_id;
					
					cmp.parseAndRunScript(res.object.data, 'modx-resource-tvs-div'+res_id);
					cmp.renderTVtabs(res_id);
					//cmp.renderTV(res_id,tv_values,grEdit.config.context);
                                        
                                },scope:this}
                            }
                        });
                        
                    });
		    
                } else {
                    t.setValue(this.config.record.template);
                }
            },this);
        }
    }
    
    ,cleanupEditor: function() {
        if (MODx.onSaveEditor) {
            var fld = Ext.getCmp('ta');
            if (fld) { MODx.onSaveEditor(fld); }
        }
    }

    ,getFields: function(config) {
        var it = [];
        it.push({
            title: _(this.classLexiconKey)
            ,id: 'modx-resource-settings'+this.ident
            ,cls: 'modx-resource-tab'
            ,layout: 'form'
            ,labelAlign: 'top'
            ,labelSeparator: ''
            ,bodyCssClass: 'tab-panel-wrapper main-wrapper'
            ,autoHeight: true
            ,defaults: {
                border: false
                ,msgTarget: 'under'
                ,width: 400
            }
            ,items: this.getMainFields(config)
        });
        it.push({
            id: 'modx-page-settings'+this.ident
            ,title: _('settings')
            ,cls: 'modx-resource-tab'
            ,layout: 'form'
            ,forceLayout: true
            ,deferredRender: false
            ,labelWidth: 200
            ,bodyCssClass: 'main-wrapper'
            ,autoHeight: true
            ,defaults: {
                border: false
                ,msgTarget: 'under'
            }
            ,items: this.getSettingFields(config)
        });
        if (config.show_tvs && MODx.config.tvs_below_content != 1) {
            it.push(this.getTemplateVariablesPanel(config));
        }
        if (MODx.perm.resourcegroup_resource_list == 1) {
            it.push(this.getAccessPermissionsTab(config));
        }
        var its = [];
        its.push(this.getPageHeader(config),{
            id:'modx-resource-tabs'+this.ident
            ,xtype: 'modx-tabs'
            ,forceLayout: true
            ,deferredRender: false
            ,collapsible: true
            ,itemId: 'tabs'
            ,items: it
        });
        var ct = this.getContentField(config);
        if (ct) {
            its.push({
                title: _('resource_content')
                ,id: 'modx-resource-content'+this.ident
                ,layout: 'form'
                ,bodyCssClass: 'main-wrapper'
                ,autoHeight: true
                ,collapsible: true
                ,hideMode: 'offsets'
                ,items: ct
                ,style: 'margin-top: 10px'
            });
        }
        if (MODx.config.tvs_below_content == 1) {
            var tvs = this.getTemplateVariablesPanel(config);
            tvs.style = 'margin-top: 10px';
            its.push(tvs);
        }
        return its;
    }

    ,getPageHeader: function(config) {
        config = config || {record:{}};
        return {
            html: '<h2>'+_('document_new')+'</h2>'
            ,id: 'modx-resource-header'+this.ident
            ,cls: 'modx-page-header'
            ,border: false
            ,forceLayout: true
            ,anchor: '100%'
        };
    }

    ,getTemplateVariablesPanel: function(config) {
        return {
            xtype: 'group_edit_modx-panel-resource-tv'
	    ,ident: this.ident
            ,collapsed: false
            ,resource: config.resource
            ,class_key: config.record.class_key || 'modDocument'
            ,template: config.record.template
            ,anchor: '100%'
	    ,renderTo: 'modx-resource-main-columns'+this.ident
            ,border: true
        };
    }

    ,getMainFields: function(config) {
        config = config || {record:{}};
        return [{
            layout:'column'
            ,border: false
            ,anchor: '100%'
            ,id: 'modx-resource-main-columns'+this.ident
            ,defaults: {
                labelSeparator: ''
                ,labelAlign: 'top'
                ,border: false
                ,msgTarget: 'under'
            }
            ,items:[{
                columnWidth: .67
                ,layout: 'form'
                ,id: 'modx-resource-main-left'+this.ident
                ,defaults: { msgTarget: 'under' }
                ,items: this.getMainLeftFields(config)
            },{
                columnWidth: .33
                ,layout: 'form'
                ,labelWidth: 0
                ,border: false
                ,id: 'modx-resource-main-right'+this.ident
                ,style: 'margin-right: 0'
                ,defaults: { msgTarget: 'under' }
                ,items: this.getMainRightFields(config)
            }]
        },{
            html: MODx.onDocFormRender, border: false
        },{
            xtype: 'hidden'
            ,fieldLabel: _('id')
            ,hideLabel: true
            ,description: '<b>[[*id]]</b><br />'
            ,name: 'id'
            ,id: 'modx-resource-id'+this.ident
            ,anchor: '100%'
            ,value: config.resource || config.record.id
            ,submitValue: true
        },{
            xtype: 'hidden'
            ,name: 'type'
            ,value: 'document'
        },{
            xtype: 'hidden'
            ,name: 'context_key'
            ,id: 'modx-resource-context-key'+this.ident
            ,value: config.record.context_key || 'web'
        },{
            xtype: 'hidden'
            ,name: 'content'
            ,id: 'hiddenContent'+this.ident
            ,value: (config.record.content || config.record.ta) || ''
        },{
            xtype: 'hidden'
            ,name: 'create-resource-token'
            ,id: 'modx-create-resource-token'+this.ident
            ,value: config.record.create_resource_token || ''
        },{
            xtype: 'hidden'
            ,name: 'reloaded'
            ,value: !Ext.isEmpty(MODx.request.reload) ? 1 : 0
        },{
            xtype: 'textfield'//'hidden'
	    ,fieldLabel: _('resource_parent')
            ,name: 'parent'
	    ,description: '<b>[[*parent]]</b><br />'+_('resource_parent_help')
            ,value: config.record.parent || 0
            ,id: 'modx-resource-parent-hidden'+this.ident
        },{
            xtype: 'hidden'
            ,name: 'parent-original'
            ,value: config.record.parent || 0
            ,id: 'modx-resource-parent-old-hidden'+this.ident
        }];
    }
    
    ,getMainLeftFields: function(config) {
        config = config || {record:{}};
        return [{
            xtype: 'textfield'
            ,fieldLabel: _('resource_pagetitle')+'<span class="required">*</span>'
            ,description: '<b>[[*pagetitle]]</b><br />'+_('resource_pagetitle_help')
            ,name: 'pagetitle'
            ,id: 'modx-resource-pagetitle'+this.ident
            ,maxLength: 255
            ,anchor: '100%'
            ,allowBlank: false
            ,enableKeyEvents: true
            ,listeners: {
                'keyup': {scope:this,fn:function(f,e) {
                    var titlePrefix = MODx.request.a == MODx.action['resource/create'] ? _('new_document') : _('document');
                    var title = Ext.util.Format.stripTags(f.getValue());
                    Ext.getCmp('modx-resource-header'+this.ident).getEl().update('<h2>'+title+'</h2>');
                }}
            }
	    
        },{
            xtype: 'textfield'
            ,fieldLabel: _('resource_longtitle')
            ,description: '<b>[[*longtitle]]</b><br />'+_('resource_longtitle_help')
            ,name: 'longtitle'
            ,id: 'modx-resource-longtitle'+this.ident
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.longtitle || ''
	    
        },{
            xtype: 'textarea'
            ,fieldLabel: _('resource_description')
            ,description: '<b>[[*description]]</b><br />'+_('resource_description_help')
            ,name: 'description'
            ,id: 'modx-resource-description'+this.ident
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.description || ''

        },{
            xtype: 'textarea'
            ,fieldLabel: _('resource_summary')
            ,description: '<b>[[*introtext]]</b><br />'+_('resource_summary_help')
            ,name: 'introtext'
            ,id: 'modx-resource-introtext'+this.ident
            ,grow: true
            ,anchor: '100%'
            ,value: config.record.introtext || ''
        }];
    }

    ,getMainRightFields: function(config) {
        config = config || {};
        return [{
            xtype: 'modx-combo-template'
            ,fieldLabel: _('resource_template')
            ,description: '<b>[[*template]]</b><br />'+_('resource_template_help')
            ,name: 'template'
            ,id: 'modx-resource-template'+this.ident
            ,anchor: '100%'
            ,editable: false
            ,baseParams: {
                action: 'getList'
                ,combo: '1'
                ,limit: 0
            }
            ,listeners: {
                'select': {fn: this.templateWarning,scope: this}
            }
        },{
            xtype: 'textfield'
            ,fieldLabel: _('resource_alias')
            ,description: '<b>[[*alias]]</b><br />'+_('resource_alias_help')
            ,name: 'alias'
            ,id: 'modx-resource-alias'+this.ident
            ,maxLength: 100
            ,anchor: '100%'
            ,value: config.record.alias || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: _('resource_menutitle')
            ,description: '<b>[[*menutitle]]</b><br />'+_('resource_menutitle_help')
            ,name: 'menutitle'
            ,id: 'modx-resource-menutitle'+this.ident
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.menutitle || ''

        },{
            xtype: 'textfield'
            ,fieldLabel: _('resource_link_attributes')
            ,description: '<b>[[*link_attributes]]</b><br />'+_('resource_link_attributes_help')
            ,name: 'link_attributes'
            ,id: 'modx-resource-link-attributes'+this.ident
            ,maxLength: 255
            ,anchor: '100%'
            ,value: config.record.link_attributes || ''

        },{
            xtype: 'xcheckbox'
            ,boxLabel: _('resource_hide_from_menus')
            ,hideLabel: true
            ,description: '<b>[[*hidemenu]]</b><br />'+_('resource_hide_from_menus_help')
            ,name: 'hidemenu'
            ,id: 'modx-resource-hidemenu'+this.ident
            ,inputValue: 1
            ,checked: parseInt(config.record.hidemenu) || false

        },{
            xtype: 'xcheckbox'
            ,boxLabel: _('resource_published')
            ,hideLabel: true
            ,description: '<b>[[*published]]</b><br />'+_('resource_published_help')
            ,name: 'published'
            ,id: 'modx-resource-published'+this.ident
            ,inputValue: 1
            ,checked: parseInt(config.record.published)
        }]
    }

    ,getSettingFields: function(config) {
        config = config || {record:{}};

        var s = [{
            layout:'column'
            ,border: false
            ,anchor: '100%'
            ,defaults: {
                labelSeparator: ''
                ,labelAlign: 'top'
                ,border: false
                ,layout: 'form'
                ,msgTarget: 'under'
            }
            ,items:[{
                columnWidth: .5
                ,id: 'modx-page-settings-left'+this.ident
                ,defaults: { msgTarget: 'under' }
                ,items: [{
                    xtype: 'hidden'//'modx-field-parent-change'
                    ,fieldLabel: _('resource_parent')
                    //,description: '<b>[[*parent]]</b><br />'+_('resource_parent_help')
                    ,name: 'parent-cmb'
                    ,id: 'modx-resource-parent'+this.ident
                    ,value: config.record.parent || 0
                    ,anchor: '100%'
                },{
                    xtype: 'modx-combo-class-derivatives'
                    ,fieldLabel: _('resource_type')
                    ,description: '<b>[[*class_key]]</b><br />'
                    ,name: 'class_key'
                    ,hiddenName: 'class_key'
                    ,id: 'modx-resource-class-key'+this.ident
                    ,allowBlank: false
                    ,value: config.record.class_key || 'modDocument'
                    ,anchor: '100%'
                },{
                    xtype: 'modx-combo-content-type'
                    ,fieldLabel: _('resource_content_type')
                    ,description: '<b>[[*content_type]]</b><br />'+_('resource_content_type_help')
                    ,name: 'content_type'
                    ,hiddenName: 'content_type'
                    ,id: 'modx-resource-content-type'+this.ident
                    ,anchor: '100%'
                    ,value: config.record.content_type || (MODx.config.default_content_type || 1)

                },{
                    xtype: 'modx-combo-content-disposition'
                    ,fieldLabel: _('resource_contentdispo')
                    ,description: '<b>[[*content_dispo]]</b><br />'+_('resource_contentdispo_help')
                    ,name: 'content_dispo'
                    ,hiddenName: 'content_dispo'
                    ,id: 'modx-resource-content-dispo'+this.ident
                    ,anchor: '100%'
                    ,value: config.record.content_dispo || 0

                },{
                    xtype: 'numberfield'
                    ,fieldLabel: _('resource_menuindex')
                    ,description: '<b>[[*menuindex]]</b><br />'+_('resource_menuindex_help')
                    ,name: 'menuindex'
                    ,id: 'modx-resource-menuindex'+this.ident
                    ,width: 60
                    ,value: parseInt(config.record.menuindex) || 0
                }]
            },{
                columnWidth: .5
                ,id: 'modx-page-settings-right'+this.ident
                ,defaults: { msgTarget: 'under' }
                ,items: [{
                    xtype: 'xdatetime'
                    ,fieldLabel: _('resource_publishedon')
                    ,description: '<b>[[*publishedon]]</b><br />'+_('resource_publishedon_help')
                    ,name: 'publishedon'
                    ,id: 'modx-resource-publishedon'+this.ident
                    ,allowBlank: true
                    ,dateFormat: MODx.config.manager_date_format
                    ,timeFormat: MODx.config.manager_time_format
                    ,dateWidth: 120
                    ,timeWidth: 120
                    ,value: config.record.publishedon
                },{
                    xtype: MODx.config.publish_document ? 'xdatetime' : 'hidden'
                    ,fieldLabel: _('resource_publishdate')
                    ,description: '<b>[[*pub_date]]</b><br />'+_('resource_publishdate_help')
                    ,name: 'pub_date'
                    ,id: 'modx-resource-pub-date'+this.ident
                    ,allowBlank: true
                    ,dateFormat: MODx.config.manager_date_format
                    ,timeFormat: MODx.config.manager_time_format
                    ,dateWidth: 120
                    ,timeWidth: 120
                    ,value: config.record.pub_date
                },{
                    xtype: MODx.config.publish_document ? 'xdatetime' : 'hidden'
                    ,fieldLabel: _('resource_unpublishdate')
                    ,description: '<b>[[*unpub_date]]</b><br />'+_('resource_unpublishdate_help')
                    ,name: 'unpub_date'
                    ,id: 'modx-resource-unpub-date'+this.ident
                    ,allowBlank: true
                    ,dateFormat: MODx.config.manager_date_format
                    ,timeFormat: MODx.config.manager_time_format
                    ,dateWidth: 120
                    ,timeWidth: 120
                    ,value: config.record.unpub_date
                },{
                    xtype: 'fieldset'
                    ,items: [{
                        layout: 'column'
                        ,id: 'modx-page-settings-box-columns'+this.ident
                        ,border: false
                        ,anchor: '100%'
                        ,defaults: {
                            labelSeparator: ''
                            ,labelAlign: 'top'
                            ,border: false
                            ,layout: 'form'
                            ,msgTarget: 'under'
                        }
                        ,items: [{
                            columnWidth: .5
                            ,id: 'modx-page-settings-right-box-left'+this.ident
                            ,defaults: { msgTarget: 'under' }
                            ,items: [{
                                xtype: 'xcheckbox'
                                ,boxLabel: _('resource_folder')
                                ,description: '<b>[[*isfolder]]</b><br />'+_('resource_folder_help')
                                ,hideLabel: true
                                ,name: 'isfolder'
                                ,id: 'modx-resource-isfolder'+this.ident
                                ,inputValue: 1
                                ,checked: parseInt(config.record.isfolder) || 0

                            },{
                                xtype: 'xcheckbox'
                                ,boxLabel: _('resource_searchable')
                                ,description: '<b>[[*searchable]]</b><br />'+_('resource_searchable_help')
                                ,hideLabel: true
                                ,name: 'searchable'
                                ,id: 'modx-resource-searchable'+this.ident
                                ,inputValue: 1
                                ,checked: parseInt(config.record.searchable)
                            },{
                                xtype: 'xcheckbox'
                                ,boxLabel: _('resource_richtext')
                                ,description: '<b>[[*richtext]]</b><br />'+_('resource_richtext_help')
                                ,hideLabel: true
                                ,name: 'richtext'
                                ,id: 'modx-resource-richtext'+this.ident
                                ,inputValue: 1
                                ,checked: parseInt(config.record.richtext)
                            }]
                        },{
                            columnWidth: .5
                            ,id: 'modx-page-settings-right-box-right'+this.ident
                            ,defaults: { msgTarget: 'under' }
                            ,items: [{
                                xtype: 'xcheckbox'
                                ,boxLabel: _('resource_cacheable')
                                ,description: '<b>[[*cacheable]]</b><br />'+_('resource_cacheable_help')
                                ,hideLabel: true
                                ,name: 'cacheable'
                                ,id: 'modx-resource-cacheable'+this.ident
                                ,inputValue: 1
                                ,checked: parseInt(config.record.cacheable)

                            },{
                                xtype: 'xcheckbox'
                                ,boxLabel: _('resource_syncsite')
                                ,description: _('resource_syncsite_help')
                                ,hideLabel: true
                                ,name: 'syncsite'
                                ,id: 'modx-resource-syncsite'+this.ident
                                ,inputValue: 1
                                ,checked: parseInt(config.record.syncsite) || true

                            },{
                                xtype: 'xcheckbox'
                                ,boxLabel: _('deleted')
                                ,description: '<b>[[*deleted]]</b>'
                                ,hideLabel: true
                                ,name: 'deleted'
                                ,id: 'modx-resource-deleted'+this.ident
                                ,inputValue: 1
                                ,checked: parseInt(config.record.deleted) || false
                            }]
                        }]
                    },{
                        xtype: 'xcheckbox'
                        ,boxLabel: _('resource_uri_override')
                        ,description: _('resource_uri_override_help')
                        ,hideLabel: true
                        ,name: 'uri_override'
                        ,value: 1
                        ,checked: parseInt(config.record.uri_override) ? true : false
                        ,id: 'modx-resource-uri-override'+this.ident

                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('resource_uri')
                        ,description: '<b>[[*uri]]</b><br />'+_('resource_uri_help')
                        ,name: 'uri'
                        ,id: 'modx-resource-uri'+this.ident
                        ,maxLength: 255
                        ,anchor: '70%'
                        ,value: config.record.uri || ''
                        ,hidden: !config.record.uri_override
                    }]

                }]

            }]
        }];
        return s;
    }
    ,getContentField: function(config) {
        return [{
            id: 'modx-content-above'+this.ident
            ,border: false
        },{
            xtype: 'textarea'
            ,name: 'ta'
            ,id: 'ta'+this.ident
            ,hideLabel: true
            ,anchor: '100%'
            ,height: 400
            ,grow: false
            ,value: (config.record.content || config.record.ta) || ''
        },{
            id: 'modx-content-below'+this.ident
            ,border: false
        }];
    }

    ,getAccessPermissionsTab: function(config) {
        return {
            id: 'modx-resource-access-permissions'+this.ident
            ,autoHeight: true
            ,title: _('resource_groups')
            ,layout: 'form'
            ,anchor: '100%'
            ,items: [{
                html: '<p>'+_('resource_access_message')+'</p>'
                ,bodyCssClass: 'panel-desc'
                ,border: false
            },{
                xtype: 'modx-grid-resource-security'
                ,cls: 'main-wrapper'
                ,preventRender: true
                ,resource: config.resource
                ,mode: config.mode || 'update'
                ,"parent": config.record["parent"] || 0
                ,"token": config.record.create_resource_token
                ,reloaded: !Ext.isEmpty(MODx.request.reload)
                ,listeners: {
                    'afteredit': {fn:this.fieldChangeEvent,scope:this}
                }
            }]
        };
    }
    
});
Ext.reg('modx-panel-resource',MODx.panel.Resource);

/*
var triggerDirtyField = function(fld) {
    Ext.getCmp('modx-panel-resource').fieldChangeEvent(fld);
};
MODx.triggerRTEOnChange = function() {
    triggerDirtyField(Ext.getCmp('ta'));
};
MODx.fireResourceFormChange = function(f,nv,ov) {
    Ext.getCmp('modx-panel-resource').fireEvent('fieldChange');
};
*/



/**
 * Renders an input for an image TV
 * 
 * @class MODx.panel.ImageTV2
 * @extends MODx.Panel
 * @param {Object} config An object of configuration properties
 * @xtype group_edit_modx-panel-tv-image
 */
MODx.panel.ImageTV2 = function(config) {
    config = config || {};
    config.filemanager_url = MODx.config.filemanager_url;
    this.ident = Ext.id();
    Ext.applyIf(config,{
        layout: 'form'
        ,autoHeight: true
        ,border: false
        ,hideLabels: true
        ,defaults: {
            autoHeight: true
            ,border: false
        }
        ,items: [{
            xtype: 'hidden'
            ,name: 'tv'+config.tv
            ,id: 'tv'+this.ident
            ,value: config.value
        },{
            xtype: 'modx-combo-browser'
            ,browserEl: 'tvbrowser'+config.tv+'_'+config.res_id
            ,name: 'tvbrowser'+config.tv
            ,id: 'tvbrowser'+this.ident
            ,value: config.relativeValue
            ,hideFiles: true
            ,basePath: config.basePath || ''
            ,basePathRelative: config.basePathRelative || ''
            ,baseUrl: config.baseUrl || ''
            ,baseUrlRelative: config.baseUrlRelative || ''
            ,allowedFileTypes: config.allowedFileTypes || ''
            ,openTo: config.openTo || ''
            ,listeners: {
		'render': {fn:function() {
		    Ext.get('tv-image-preview-'+config.tv+'_'+config.res_id)
		    .update('<img src="'+MODx.config.connectors_url+'system/phpthumb.php?h=150&w=150&src='+config.value+'&wctx=web&source=1" alt="" />');
		},scope:this}
                ,'select': {fn:function(data) {
                    Ext.getCmp('tv'+this.ident).setValue(data.relativeUrl);
                    Ext.getCmp('tvbrowser'+this.ident).setValue(data.relativeUrl);
		    //MODx.fireResourceFormChange();
		    
		    var d = Ext.get('tv-image-preview-'+config.tv+'_'+config.res_id);//tv-image-preview-2-20
		    if (Ext.isEmpty(data.url)) {
			d.update('');
		    } else {
			d.update('<img src="'+MODx.config.connectors_url+'system/phpthumb.php?h=150&w=150&src='+data.url+'&wctx=web&source=1" alt="" />');
		    }
                    //this.fireEvent('select',data);
                },scope:this}
                ,'change': {fn:function(cb,nv) {
                    Ext.getCmp('tv'+this.ident).setValue(nv);
                    this.fireEvent('select',{
                        relativeUrl: nv
                        ,url: nv
                    });
                },scope:this}
            }
        }] 
    });
    MODx.panel.ImageTV2.superclass.constructor.call(this,config);
    this.addEvents({select: true});
};
Ext.extend(MODx.panel.ImageTV2,MODx.Panel);
Ext.reg('group_edit_modx-panel-tv-image',MODx.panel.ImageTV2);


/**
 * Loads the Resource TV Panel
 * 
 * @class MODx.panel.ResourceTV
 * @extends MODx.Panel
 * @param {Object} config
 * @xtype panel-resource-tv
 */
MODx.panel.ResourceTV = function(config) {
    config = config || {};
    this.ident = config.ident || Ext.id();
    Ext.applyIf(config,{
        id: 'modx-panel-resource-tv'+this.ident
        ,title: _('template_variables')
        ,class_key: ''
        ,resource: ''
	,border: false
        ,cls: MODx.config.tvs_below_content == 1 ? 'x-panel-body tvs-wrapper' : 'tvs-wrapper x-panel-body'
        ,autoHeight: true
        ,applyTo: 'modx-resource-tvs-div'+this.ident
        ,header: false
        ,templateField: 'modx-resource-template'+this.ident
    });
    MODx.panel.ResourceTV.superclass.constructor.call(this,config);
    this.addEvents({ load: true });
};
Ext.extend(MODx.panel.ResourceTV,MODx.Panel,{
    autoload: function() {
        return false;
    }
    ,refreshTVs: function() {
        return false;
        var t = Ext.getCmp(this.config.templateField);
        if (!t && !this.config.template) { return false; }
        var template = this.config.template ? this.config.template : t.getValue();
        
        this.getUpdater().update({
            url: MODx.config.manager_url+'index.php?a='+MODx.action['resource/tvs']
            ,method: 'GET'
            ,params: {
               'class_key': this.config.class_key
               ,'template': template
               ,'resource': this.config.resource
            }
            ,scripts: true
            ,callback: function() {
                this.fireEvent('load');
                if (MODx.afterTVLoad) { MODx.afterTVLoad(); }
            }
            ,scope: this
        });
    }
});
Ext.reg('group_edit_modx-panel-resource-tv',MODx.panel.ResourceTV);



/**
 * ChangeParent
 *
 */
