// API and Bancha is already included,
// now load sample dependencies
Ext.require([
    'Ext.grid.*'
]);


// when Bancha is ready, the model meta data is loaded
// from the server and the model is created....
Bancha.onModelReady('User', function(userModel) {


    // ... create a full featured users grid
    Ext.create('Ext.grid.Panel', 
        Bancha.scarfold.buildGridPanelConfig('User', {
            create: true,
            update: true,
            withReset: true,
            destroy: true
        }, {
            height: 350,
            width: 600,
            title: 'Company Grid',
            renderTo: 'gridpanel'
        })
    );

    // ... and some charts
    // TODO Add Chart sample
    // http://dev.sencha.com/deploy/ext-4.0.0/examples/charts/Column.html
});