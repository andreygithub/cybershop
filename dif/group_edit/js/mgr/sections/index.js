
Ext.onReady(function() {
    MODx.load({
        xtype: 'group_edit-cmp'
        ,id: 'group_edit-cmp'
        ,renderTo: 'group_edit-panel'
    });
});

Ext.ux.clone = function(o) {
    if(!o || 'object' !== typeof o) {
        return o;
    }
    if('function' === typeof o.clone) {
        return o.clone();
    }
    var c = '[object Array]' === Object.prototype.toString.call(o) ? [] : {};
    var p, v;
    for(p in o) {
        if(o.hasOwnProperty(p)) {
            v = o[p];
            if(v && 'object' === typeof v) {
                c[p] = Ext.ux.clone(v);
            }
            else {
                c[p] = v;
            }
        }
    }
    return c;
};


if(!Object.keys) Object.keys = function(o){
   if (o !== Object(o))
      throw new TypeError('Object.keys called on non-object');
   var ret=[],p;
   for(p in o) if(Object.prototype.hasOwnProperty.call(o,p)) ret.push(p);
   return ret;
}


