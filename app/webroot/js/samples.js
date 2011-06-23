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
        Bancha.scarfold.buildGridPanelConfig('User', { //TODO grid functions richten
            create: true,
            update: true,
            withReset: true,
            destroy: true
        }, {
            height: 350,
            width: 650,
            frame: true,
            title: 'User Grid',
            renderTo: 'gridpanel'
        })
    );

    // create form upload
    Ext.create('Ext.form.Panel', {
        width: 650,
        frame:true,
        title: 'Form with upload field',
        renderTo: 'form',
        bodyStyle:'padding:5px 5px 0',
        fieldDefaults: {
            msgTarget: 'side',
            labelWidth: 75
        },
        defaultType: 'textfield',
        defaults: {
            anchor: '100%'
        },

        items: [{ //TODO use scarfolding
            fieldLabel: 'Name',
            name: 'name',
            allowBlank:false
        },{
            fieldLabel: 'User Name',
            name: 'login'
        },{
            fieldLabel: 'Email',
            name: 'email'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Weight',
            name: 'weight'
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Height',
            name: 'height'
        }, {
            xtype: 'filefield',
            emptyText: 'Select an image',
            buttonText: '',
            buttonConfig: {
                iconCls: 'icon-upload'
            },
            fieldLabel: 'Avatar',
            name: 'avatar'
        }, {
            xtype: 'container', 
            data: { avatar: 'none' },// TODO fixsss
            renderTpl: 'most recently uploaded image: {avatar}<image src="{avatar}" style="width:100px;" title="most recently uploaded image">'
        }],

        buttons: [{
            text: 'reset',
            handler: function() {
                this.up('form').getForm().reset();
            }
        },{
            text: 'Save', // TODO attach meaning
            formBind: true,
            handler: function(){
                var form = this.up('form').getForm();
                if(form.isValid()){
                    form.submit({
                        url: 'file-upload.php',
                        waitMsg: 'Uploading your photo...',
                        success: function(fp, o) {
                            msg('Success', 'Processed file "' + o.result.file + '" on the server');
                        }
                    });
                }
            }
        }]
    });
    
    
    
    // ... and some charting
    Ext.create("Ext.panel.Panel", {
        title: 'Column Chart',
        renderTo: 'chart',
        layout: 'fit',
        width: 650,
        height: 350,
        items: {
            xtype: 'chart',
            style: 'background:#fff',
            animate: true,
            shadow: true,
            store: Ext.create("Ext.data.Store",{
                model: 'User',
                autoLoad: true
            }),
            axes: [{
                type: 'Numeric',
                position: 'left',
                fields: ['height'],
                label: {
                    renderer: Ext.util.Format.numberRenderer('0,0')
                },
                title: 'Persons Height',
                grid: true,
                minimum: 0
            }, {
                type: 'Category',
                position: 'bottom',
                fields: ['name'],
                title: 'User'
            }],
            series: [{
                type: 'column',
                axis: 'left',
                highlight: true,
                tips: {
                  trackMouse: true,
                  width: 140,
                  height: 28,
                  renderer: function(storeItem, item) {
                    this.setTitle(storeItem.get('name') + ': ' + storeItem.get('height') + 'cm');
                  }
                },
                label: {
                  display: 'insideEnd',
                  'text-anchor': 'middle',
                    field: 'height',
                    renderer: Ext.util.Format.numberRenderer('0'),
                    orientation: 'vertical',
                    color: '#333'
                },
                xField: 'name',
                yField: 'height'
            }]
        }
     });
    // TODO Add Chart sample
    // http://dev.sencha.com/deploy/ext-4.0.0/examples/charts/Column.html
});