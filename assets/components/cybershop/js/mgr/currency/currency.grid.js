Cybershop.grid.Currency = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'cybershop-grid-currency'
        ,url: Cybershop.config.connectorUrl
        ,baseParams: { action: 'mgr/currency/getList'}
        ,save_action: 'mgr/currency/updateFromGrid' 
        ,fields: ['id','name','shortname','description','image','rate','main']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '100%'
        ,autoExpandColumn: 'name'
        ,columns: [{
            header: _('cs_id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 60
        },{
            header: _('cs_main')
            ,dataIndex: 'main'
            ,sortable: true
            ,width: 30
           ,renderer: this.renderBoolean
        },{
            header: _('cs_name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 100
        },{
            header: _('cs_description')
            ,dataIndex: 'description'
            ,sortable: false
            ,width: 350
        },{
            header: _('cs_shortname')
            ,dataIndex: 'shortname'
            ,sortable: false
            ,width: 50
         },{
            header: _('cs_rate')
            ,dataIndex: 'rate'
            ,sortable: false
            ,editor: new Ext.form.NumberField({
                decimalPrecision: 5
                ,allowBlank: false
                ,allowNegative: false
                ,maxValue: 100000
            })
            ,width: 100
        }]

	,tbar: [{
            text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-currency' 
                ,title: _('cs_element_create')
                ,blankValues: true
                ,baseParams: {action: 'mgr/currency/create'}
            }
        }]

       
     });
    Cybershop.grid.Currency.superclass.constructor.call(this,config)
};

Ext.extend(Cybershop.grid.Currency,MODx.grid.Grid,{
    getMenu: function() {
        return [{
	     text: _('cs_element_create')
            ,handler: { xtype: 'cybershop-window-currency' 
                        ,blankValues: true
                        ,title: _('cs_element_create')
                      }
        },{
            text: _('cs_element_update')
            ,handler: this.updateElement
        },{
            text: _('cs_element_remove')
            ,handler: this.removeElement
        }];
    }
    ,updateElement: function(btn,e) {
        if (!this.updateCurrencyWindow) {
            this.updateCurrencyWindow = MODx.load({
                xtype: 'cybershop-window-currency'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateCurrencyWindow.setValues(this.menu.record);
        this.updateCurrencyWindow.show(e.target);
    }

    ,removeElement: function() {
        MODx.msg.confirm({
            title: _('cs_element_remove')
            ,text: _('cs_element_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/currency/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    , renderBoolean: function(value) {
            if (value == 1) {return  '<input type="checkbox" checked disabled>'; }//_('yes');}
            else {return '<input type="checkbox" disabled>'; }//_('no');}
    }
});
Ext.reg('cybershop-grid-currency',Cybershop.grid.Currency);

