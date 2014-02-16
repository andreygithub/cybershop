var groupEdit = function(config) {
    config = config || {};
    groupEdit.superclass.constructor.call(this,config);
};
Ext.extend(groupEdit,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},tab:{},config: {}
});
Ext.reg('resTabs',groupEdit);

grEdit = new groupEdit();