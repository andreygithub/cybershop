/**
 * The Movies store
 */
Ext.define('GeekFlicks.store.Movies', {
    extend: 'Ext.data.Store',

    autoLoad: true,
    fields: ['title', 'year'],

    proxy: {
        type: 'ajax',
        url: '/movies',
        reader: {
            type: 'json',
            root: 'data',
            successProperty: 'success'
        }
    }
});
