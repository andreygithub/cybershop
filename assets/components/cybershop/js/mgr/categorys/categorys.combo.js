Cybershop.combo.Categorys = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'category'
        ,hiddenName: 'category'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fields: ['name','id','description']
        ,listWidth: 500
        ,pageSize: 50
        ,url: Cybershop.config.connectorUrl
        ,tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item"><span style="font-weight: bold">{name}</span>'
            ,'<br />{description}</div></tpl>')
    });
    Cybershop.combo.Categorys.superclass.constructor.call(this,config);
    };
    
Ext.extend(Cybershop.combo.Categorys,MODx.combo.ComboBox);
Ext.reg('cybershop-combo-categorys',Cybershop.combo.Categorys);

Cybershop.combo.winCategorys = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'category'
        ,hiddenName: 'category'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fields: ['name','id','description']
        ,listWidth: 500
        ,pageSize: 50
        ,url: Cybershop.config.connectorUrl
        ,tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item"><span style="font-weight: bold">{name}</span>'
            ,'<br />{description}</div></tpl>')
    });
    Cybershop.combo.winCategorys.superclass.constructor.call(this,config);
    };
    
Ext.extend(Cybershop.combo.winCategorys,MODx.combo.ComboBox);
Ext.reg('cybershop-combo-wincategorys',Cybershop.combo.winCategorys);

Cybershop.combo.winCategorysUpdate = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'category'
        ,hiddenName: 'category'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fields: ['name','id','description']
        ,listWidth: 500
        ,pageSize: 50
        ,url: Cybershop.config.connectorUrl
        ,tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item"><span style="font-weight: bold">{name}</span>'
            ,'<br />{description}</div></tpl>')
    });
    Cybershop.combo.winCategorysUpdate.superclass.constructor.call(this,config);
    };
    
Ext.extend(Cybershop.combo.winCategorysUpdate,MODx.combo.ComboBox);
Ext.reg('cybershop-combo-wincategorys-update',Cybershop.combo.winCategorysUpdate);