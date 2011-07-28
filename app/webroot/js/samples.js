/*jslint browser: true, vars: false, plusplus: true, white: true, sloppy: true */
/*global Ext, Bancha */

// API and Bancha is already included,
// now load sample dependencies
Ext.require([
    'Ext.from.*',
    'Ext.grid.*'
]);


// when Bancha is ready, the model meta data is loaded
// from the server and the model is created....
Bancha.onModelReady('User', function(userModel) {

    // ... create a full featured users grid
    Ext.create('Ext.grid.Panel', {
        scaffold: 'User', // model name
        
        // basic scaffold configs con be set directly
        enableCreate : true,
        enableUpdate : true,
        enableDestroy: true,
        enableReset  : true,
        
        // advanced confgis can be set here
        scaffoldConfig: {
            datecolumnDefaults: {
                format: 'm/d/Y'
            },
            // use the same store for multiple grids
            oneStorePerModel :true
        },
        
        // some additional styles
        height: 350,
        width: 650,
        frame: true,
        title: 'User Grid',
        renderTo: 'gridpanel'
    });
    // PS: Actually all "changed" scaffold configs are already defaults
    // (expect scaffold:'User' of course)

    /*
     * create form upload
     */
    // For all created forms overwrite file upload defaults for nicer styling
    Bancha.scaffold.Form.fileuploadfieldDefaults = {
        buttonText: '',
        buttonConfig: {
            iconCls: 'icon-upload'
        }
    };
    
    Ext.create('Ext.form.Panel', {
        scaffold: 'User',
        
        // basic scaffold configs con be set directly
        loadBanchaRecord: false,
        enableReset: true,
        
        // advanced confgis can be set here
        scaffoldConfig: {
            // we're using the after interceptor for bigger changes
            afterBuild: function(formConfig) {
                // change the order, so that the avatar field is the last element
                formConfig.items.push(formConfig.items.splice(5,1)[0]);
                
                // add another item after the avatar field
                formConfig.items.push({ //TODO add support for this to display the image
                    xtype: 'component', 
                    data: { avatar: 'none' },// TODO fixsss
                    tpl: '<tpl if="avatar!=\'none\'"><span class="uploaded-image">most recently uploaded image: {avatar}<image src="{avatar}" style="width:100px;" title="most recently uploaded image"></span></tpl>'
                });
                console.info(formConfig);
                // add another button
                formConfig.buttons.unshift({
                    text: 'Load Record 1',
                    iconCls: 'icon-edit-user', // TODO css
                    handler: function() {
                        var formPanel = this.getPanel(),
                            form = this.getForm();
                        // load the form // scopeButtonHandler allows to get the form with this.getForm()
                        form.load({
                            params: {
                                data: { id:1 }
                            }
                        });
                        // change the header title
                        formPanel.setTitle('Form with upload field - Change Record 1');
                    },
                    scope: this.buildButtonScope(formConfig.id) // this is currently not very elegant, we will solve thsi in future releases
                });
                
                return formConfig;
            } //eo afterBuild
        }, // eo scaffoldConfig
        
        
        // some additional styles
        width: 650,
        frame:true,
        title: 'Form with upload field - Create a new User',
        renderTo: 'formpanel',
        id: 'form',
        bodyStyle:'padding:5px 5px 0',
        fieldDefaults: {
            msgTarget: 'side',
            labelWidth: 75
        },
        defaultType: 'textfield',
        defaults: {
            anchor: '100%'
        }
    }); // eo create
    
    
    // ... and some standard extjs charting
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

});

// eof
