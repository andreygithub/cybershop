
Cybershop.window.Catalog = function(config){
  config = config || {};
  config.id = Ext.id();
  Ext.applyIf(config, {
    id: config.id,
    url: Cybershop.config.connectorUrl,
    baseParams: {
      action: 'mgr/catalog/update'
    },
    width: 1100, // maximized: true
    minWidth: 500,
    height: 400,
    fields:
      [{
          xtype: 'hidden',
          name: 'id'
        }, {
          xtype: 'panel',
          border: false,
          cls: 'main-wrapper',
          layout: 'form',
          labelAlign: 'top',
          labelSeparator: '',
          items:
            [{
                xtype: 'modx-tabs',
                defaults: {
                  autoHeight: true,
                  border: true,
                  bodyCssClass: 'tab-panel-wrapper'
                },
                forceLayout: true,
                deferredRender: false,
                items:
                  [{
                      title: _('cs_tabs_main'),
                      layout: 'form',
                      items:
                        [{
                            layout: 'column',
                            border: false,
                            items:
                              [{
                                  columnWidth: .6,
                                  layout: 'form',
                                  items:
                                    [{
                                        xtype: 'textfield',
                                        fieldLabel: _('cs_name') + ' <small>' + _('cs_name_desc') + '</small>',
                                        name: 'name',
                                        anchor: '100%'
                                      }, {
                                        xtype: 'textfield',
                                        fieldLabel: _('cs_description') + ' <small>' + _('cs_description_desc') + '</small>',
                                        name: 'description',
                                        anchor: '100%'
                                      }, {
                                        xtype: 'textarea',
                                        fieldLabel: _('cs_introtext') + ' <small>' + _('cs_introtext_desc') + '</small>',
                                        name: 'introtext',
                                        anchor: '100%'
                                      }]
                                }, {
                                  columnWidth: .4,
                                  layout: 'form',
                                  items:
                                    [{
                                        xtype: 'textfield',
                                        fieldLabel: _('cs_article') + ' <small>' + _('cs_article_desc') + '</small>',
                                        name: 'article',
                                        anchor: '100%'
                                      }, {
                                        xtype: 'textfield',
                                        fieldLabel: _('cs_alias') + ' <small>' + _('cs_alias_desc') + '</small>',
                                        name: 'alias',
                                        anchor: '100%'
                                      }, {
                                        layout: 'column',
                                        border: false,
                                        items:
                                          [{
                                              columnWidth: .5,
                                              layout: 'form',
                                              items:
                                                [{
                                                    xtype: 'xcheckbox',
                                                    boxLabel: _('cs_active') + ' <small>' + _('cs_active_desc') + '</small>',
                                                    name: 'active',
                                                    anchor: '99%'
                                                  }, {
                                                    xtype: 'xcheckbox',
                                                    boxLabel: _('cs_deleted') + ' <small>' + _('cs_deleted_desc') + '</small>',
                                                    name: 'deleted',
                                                    anchor: '99%'
                                                  }, {
                                                    xtype: 'xcheckbox',
                                                    boxLabel: _('cs_new') + ' <small>' + _('cs_new_desc') + '</small>',
                                                    name: 'new',
                                                    anchor: '99%'
                                                  }]
                                            }, {
                                              columnWidth: .5,
                                              layout: 'form',
                                              items:
                                                [{
                                                    xtype: 'xcheckbox',
                                                    boxLabel: _('cs_sellout') + ' <small>' + _('cs_sellout_desc') + '</small>',
                                                    name: 'sellout',
                                                    anchor: '99%'
                                                  }, {
                                                    xtype: 'xcheckbox',
                                                    boxLabel: _('cs_discount') + ' <small>' + _('cs_discount_desc') + '</small>',
                                                    name: 'discount',
                                                    anchor: '99%'
                                                  }, {
                                                    xtype: 'xcheckbox',
                                                    boxLabel: _('cs_onhomepage') + ' <small>' + _('cs_onhomepage_desc') + '</small>',
                                                    name: 'onhomepage',
                                                    anchor: '99%'
                                                  }]
                                            }]

                                      }]
                                }]
                          }, {
                            xtype: 'htmleditor',
                            hideLabel: false,
                            fieldLabel: _('cs_fulltext') + ' <small>' + _('cs_fulltext_desc') + '</small>',
                            name: 'fulltext',
                            anchor: '100%',
                            minWidth: 500,
                            height: 200,
                            handler: function(){
                              Ext.get('styleswitcher').on('click', function(e){
                                Ext.getCmp('form-widgets').getForm().reset();
                              });
                            }
                          }]
                    }, {
                      title: _('cs_tabs_filters')
                      ,
                      layout: 'form'
                      ,
                      items:
                        [{
                            xtype: 'modx-combo'
                            ,
                            fieldLabel: _('cs_brand') + ' <small>' + _('cs_brand_desc') + '</small>'
                            ,
                            name: 'brand'
                            ,
                            hiddenName: 'brand'
                            ,
                            emptyText: _('cs_selectElement') + '...'
                            ,
                            url: Cybershop.config.connectorUrl
                            ,
                            baseParams: {
                              action: 'mgr/brands/getList'
                              ,
                              addAll: false
                            }
                            ,
                            pageSize: 20
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'modx-combo'
                            ,
                            fieldLabel: _('cs_category') + ' <small>' + _('cs_category_desc') + '</small>'
                            ,
                            name: 'category'
                            ,
                            hiddenName: 'category'
                            ,
                            emptyText: _('cs_selectElement') + '...'
                            ,
                            url: Cybershop.config.connectorUrl
                            ,
                            baseParams: {
                              action: 'mgr/categorys/getList'
                              ,
                              combo: true
                              ,
                              addAll: false
                            }
                            ,
                            listWidth: 500
                            ,
                            pageSize: 50
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'cybershop-grid-filtertable'
                            ,
                            id: config.id + '-grid-filtertable'
                            ,
                            winid: config.id
                            ,
                            fieldLabel: _('cs_filters')
                            ,
                            name: 'id'
                            ,
                            anchor: '99%'
                          }]
                    }, {
                      title: _('cs_tabs_properties')
                      ,
                      layout: 'form'
                      ,
                      items:
                        [{
                            xtype: 'cybershop-grid-propertytable'
                            ,
                            id: config.id + '-grid-propertytable'
                            ,
                            winid: config.id
                            ,
                            fieldLabel: _('cs_properties')
                            ,
                            hideLabel: true
                            ,
                            name: 'id'
                            ,
                            anchor: '99%'
                              //                        },{
                              //                            xtype: 'textarea'
                              //                            ,fieldLabel: _('cs_json_properties') + ' <small>' + _('cs_json_properties_desc') + '</small>'
                              //                            ,name: 'properties'
                              //                            ,anchor: '99%'
                              //                            ,height: 400
                          }]
                    }, {
                      title: _('cs_tabs_complects')
                      ,
                      layout: 'form'
                      ,
                      items:
                        [{
                            xtype: 'cybershop-grid-complects'
                            ,
                            id: config.id + '-grid-complects'
                            ,
                            winid: config.id
                            ,
                            fieldLabel: _('cs_grid_complects')
                            ,
                            name: 'id'
                            ,
                            anchor: '99%'
                          }]
                    }, {
                      title: _('cs_tabs_price')
                      ,
                      layout: 'form'
                      ,
                      items:
                        [{
                            xtype: 'numberfield'
                            ,
                            fieldLabel: _('cs_price1') + ' <small>' + _('cs_price1_desc') + '</small>'
                            ,
                            name: 'price1'
                            ,
                            decimalPrecision: 2
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'numberfield'
                            ,
                            fieldLabel: _('cs_price2') + ' <small>' + _('cs_price2_desc') + '</small>'
                            ,
                            name: 'price2'
                            ,
                            decimalPrecision: 2
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'numberfield'
                            ,
                            fieldLabel: _('cs_price3') + ' <small>' + _('cs_price3_desc') + '</small>'
                            ,
                            name: 'price3'
                            ,
                            decimalPrecision: 2
                            ,
                            anchor: '99%'
                          }]
                    }, {
                      title: _('cs_tabs_value')
                      ,
                      layout: 'form'
                      ,
                      items:
                        [{
                            xtype: 'numberfield'
                            ,
                            fieldLabel: _('cs_value1') + ' <small>' + _('cs_value1_desc') + '</small>'
                            ,
                            name: 'value1'
                            ,
                            decimalPrecision: 3
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'numberfield'
                            ,
                            fieldLabel: _('cs_value2') + ' <small>' + _('cs_value2_desc') + '</small>'
                            ,
                            name: 'value2'
                            ,
                            decimalPrecision: 3
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'numberfield'
                            ,
                            fieldLabel: _('cs_value3') + ' <small>' + _('cs_value3_desc') + '</small>'
                            ,
                            name: 'value3'
                            ,
                            decimalPrecision: 3
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'numberfield'
                            ,
                            fieldLabel: _('cs_weight') + ' <small>' + _('cs_weight_desc') + '</small>'
                            ,
                            name: 'weight'
                            ,
                            decimalPrecision: 3
                            ,
                            anchor: '99%'
                          }]
                    }, {
                      title: _('cs_tabs_images')
                      ,
                      layout: 'form'
                      ,
                      items:
                        [{
                            xtype: 'cybershop-combo-browser'
                            ,
                            id: config.id + '-image'
                            ,
                            fieldLabel: _('cs_main_image') + ' <small>' + _('cs_main_image_desc') + '</small>'
                            ,
                            name: 'image'
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'cybershop-grid-images'
                            ,
                            fieldLabel: _('cs_add_images')
                            ,
                            id: config.id + '-grid-images'
                            ,
                            winid: config.id
                            ,
                            name: 'id'
                            ,
                            anchor: '99%'
                          }]
                    }, {
                      title: _('cs_tabs_similars')
                      ,
                      layout: 'form'
                      ,
                      items:
                        [{
                            xtype: 'cybershop-grid-similars'
                            ,
                            id: config.id + '-grid-similars'
                            ,
                            winid: config.id
                            ,
                            fieldLabel: _('cs_grid_similars')
                            ,
                            name: 'id'
                            ,
                            anchor: '99%'
                          }]
                    }, {
                      title: _('cs_tabs_add')
                      ,
                      layout: 'form'
                      ,
                      items:
                        [{
                            xtype: 'textfield'
                            ,
                            fieldLabel: _('cs_made_in') + ' <small>' + _('cs_made_in_desc') + '</small>'
                            ,
                            name: 'made_in'
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'textfield'
                            ,
                            fieldLabel: _('cs_url') + ' <small>' + _('cs_url_desc') + '</small>'
                            ,
                            name: 'url'
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'cybershop-combo-browser'
                            ,
                            id: config.id + '-media'
                            ,
                            fieldLabel: _('cs_media') + ' <small>' + _('cs_media_desc') + '</small>'
                            ,
                            name: 'media'
                            ,
                            anchor: '99%'
                          }]
                    }, {
                      title: _('cs_tabs_ceo')
                      ,
                      layout: 'form'
                      ,
                      items:
                        [{
                            xtype: 'textfield'
                            ,
                            fieldLabel: _('cs_ceo_data') + ' <small>' + _('cs_ceo_data_desc') + '</small>'
                            ,
                            name: 'ceo_data'
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'textfield'
                            ,
                            fieldLabel: _('cs_ceo_key') + ' <small>' + _('cs_ceo_key_desc') + '</small>'
                            ,
                            name: 'ceo_key'
                            ,
                            anchor: '99%'
                          }, {
                            xtype: 'textarea'
                            ,
                            fieldLabel: _('cs_ceo_description') + ' <small>' + _('cs_ceo_description_desc') + '</small>'
                            ,
                            name: 'ceo_description'
                            ,
                            anchor: '99%'
                          }]
                    }]
              }]
        }]
    ,
    buttons: [{
        text: config.cancelBtnText || _('cancel')
        ,
        scope: this
        ,
        handler: function(){
          this.hide();
        }
      }, {
        text: config.saveBtnText || _('save')
        ,
        scope: this
        ,
        handler: function(){
          this.savenew();
        }
      }, {
        text: config.saveBtnText || _('save_and_close')
        ,
        scope: this
        ,
        handler: this.submit
      }]

  });
  Cybershop.window.Catalog.superclass.constructor.call(this, config);
  this.on('show', function(){
    if (this.config.blankValues) {
      this.blankValues = true;
      this.fp.getForm().reset();
      this.fp.getForm().baseParams = this.config.baseParams;
      this.config.filterCatalog = -1;
      this.config.filterBrand = -1;
      this.config.filterCategory = -1;
      this.setTableFilterCatalog(this.config.filterCatalog);
      this.setTableFilterBrand(this.config.filterBrand);
      this.setTableFilterCategory(this.config.filterCategory);
      this.setTableFilter();
    }
    else {
      this.setTableFilterCatalog(this.fp.getForm().items.itemAt(0).getValue());
      this.setTableFilterBrand(this.fp.getForm().items.itemAt(6).getValue());
      this.setTableFilterCategory(this.fp.getForm().items.itemAt(7).getValue());
      this.setTableFilter();
    }
    if (this.config.allowDrop) {
      this.loadDropZones();
    }
    this.syncSize();
    this.focusFirstField();
  }, this);
};
Ext.extend(Cybershop.window.Catalog, MODx.Window, {
  savenew: function(){
    var f = this.fp.getForm();

    f.submit({
      waitMsg: _('saving')
      ,
      scope: this
      ,
      failure: function(frm, a){
        if (this.fireEvent('failure', {
          f: frm,
          a: a
        })) {
          MODx.form.Handler.errorExt(a.result, frm);
        }
      }
      ,
      success: function(frm, a){

        if (this.config.success) {
          Ext.callback(this.config.success, this.config.scope || this, [frm, a]);

        }
        this.fireEvent('success', {
          f: frm,
          a: a
        });
        var r = Ext.decode(a.response.responseText);
        this.setValues(r.object);
        this.fp.getForm().baseParams = {
          action: 'mgr/catalog/update'
        };
        this.blankValues = false;
        this.setTableFilterCatalog(this.fp.getForm().items.itemAt(0).getValue());
        this.setTableFilterBrand(this.fp.getForm().items.itemAt(6).getValue());
        this.setTableFilterCategory(this.fp.getForm().items.itemAt(7).getValue());
        this.setTableFilter();
      }
    });
  }
  ,
  setTableFilterCatalog: function(filtervalue){
    Ext.getCmp(this.config.id + '-grid-filtertable').config.filterCatalog = filtervalue;
    Ext.getCmp(this.config.id + '-grid-propertytable').config.filterCatalog = filtervalue;
    Ext.getCmp(this.config.id + '-grid-complects').config.filterId = filtervalue;
    Ext.getCmp(this.config.id + '-grid-similars').config.filterId = filtervalue;
    Ext.getCmp(this.config.id + '-grid-images').config.filterId = filtervalue;
    Ext.getCmp(this.config.id + '-image').config.rootId = Cybershop.config.catalog_image_path + 'catalog/' + filtervalue + '/';
    Ext.getCmp(this.config.id + '-media').config.rootId = Cybershop.config.catalog_media_path + 'catalog/' + filtervalue + '/';
  }
  ,
  setTableFilterBrand: function(filtervalue){
    Ext.getCmp(this.config.id + '-grid-filtertable').config.filterBrand = filtervalue;
  }
  ,
  setTableFilterCategory: function(filtervalue){
    Ext.getCmp(this.config.id + '-grid-filtertable').config.filterCategory = filtervalue;
  }
  ,
  setTableFilter: function(){
    Ext.getCmp(this.config.id + '-grid-filtertable').setFilter();
    Ext.getCmp(this.config.id + '-grid-propertytable').setFilter();
    Ext.getCmp(this.config.id + '-grid-complects').setFilter();
    Ext.getCmp(this.config.id + '-grid-similars').setFilter();
    Ext.getCmp(this.config.id + '-grid-images').setFilter();
  }

});
Ext.reg('cybershop-window-catalog', Cybershop.window.Catalog);

