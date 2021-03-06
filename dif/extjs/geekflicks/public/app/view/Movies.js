/**
 * The Grid of Movies
 */
Ext.define('GeekFlicks.view.Movies', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.movieseditor',

    store: 'Movies',

    initComponent: function () {
        this.columns = [
            {
                header: 'Title',
                dataIndex: 'title',
                flex: 1
            },
            {
                header: 'Year',
                dataIndex: 'year',
                flex: 1
            }
        ];
        this.callParent(arguments);
    }
});
