/**
 * The app Viewport. This is the default view displayed when the app is loaded.
 * It is rendered automatically when `autoCreateViewport` is set to `true` in
 * the configuration object given to `Ext.application`.
 */
Ext.define('GeekFlicks.view.Viewport', {
    extend: 'Ext.container.Viewport',

    layout: 'fit',

    items: [{
        xtype: 'panel',
        title: 'Top Geek Flicks of All Time',
        items: [{
            xtype: 'movieseditor'
        }]
    }]
});