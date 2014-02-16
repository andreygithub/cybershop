var Cybershop = function(config) {
    config = config || {};
    Cybershop.superclass.constructor.call(this,config);
};
Ext.extend(Cybershop,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},field: {}
});
Ext.reg('cybershop',Cybershop);

Cybershop = new Cybershop();
