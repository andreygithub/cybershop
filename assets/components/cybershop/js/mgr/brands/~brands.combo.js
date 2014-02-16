Cybershop.combo.Brands = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'brand'
        ,hiddenName: 'brand'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fields: ['name','id','description']
        ,listWidth: 300
        ,pageSize: 20
        ,url: Cybershop.config.connectorUrl
        ,tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item"><span style="font-weight: bold">{name}</span>'
            ,'<br />{description}</div></tpl>')
    });
    Cybershop.combo.Brands.superclass.constructor.call(this,config);
    };
    
Ext.extend(Cybershop.combo.Brands,MODx.combo.ComboBox);
Ext.reg('cybershop-combo-brands',Cybershop.combo.Brands);

Cybershop.combo.winBrands = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'brand'
        ,hiddenName: 'brand'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fields: ['name','id','description']
        ,listWidth: 300
        ,pageSize: 20
        ,url: Cybershop.config.connectorUrl
        ,tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item"><span style="font-weight: bold">{name}</span>'
            ,'<br />{description}</div></tpl>')
    });
    Cybershop.combo.winBrands.superclass.constructor.call(this,config);
    };
    
Ext.extend(Cybershop.combo.winBrands,MODx.combo.ComboBox);
Ext.reg('cybershop-combo-winbrands',Cybershop.combo.winBrands);

Cybershop.combo.winBrandsUpdate = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'brand'
        ,hiddenName: 'brand'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fields: ['name','id','description']
        ,listWidth: 300
        ,pageSize: 20
        ,url: Cybershop.config.connectorUrl
        ,tpl: new Ext.XTemplate('<tpl for="."><div class="x-combo-list-item"><span style="font-weight: bold">{name}</span>'
            ,'<br />{description}</div></tpl>')
    });
    Cybershop.combo.winBrandsUpdate.superclass.constructor.call(this,config);
    };
    
Ext.extend(Cybershop.combo.winBrandsUpdate,MODx.combo.ComboBox);
Ext.reg('cybershop-combo-winbrands-update',Cybershop.combo.winBrandsUpdate);

