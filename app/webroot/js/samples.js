/*jslint browser: true, vars: false, plusplus: true, white: true, sloppy: true */
/*global Ext, Bancha */

// API and Bancha is already included,
// now load sample dependencies
Ext.require([
    'Ext.grid.*'
]);


// when Bancha is ready, the model meta data is loaded
// from the server and the model is created....
Bancha.onModelReady('User', function(userModel) {

    // ... create a full featured users grid
    Bancha.scaffold.Grid.createPanel('User', {
        // you can overwrite defaults either like this
        enableDestroy: true
        // or permanent with Bancha.scaffold.Grid.enableDestroy = true;
    }, {
        height: 350,
        width: 650,
        frame: true,
        title: 'User Grid',
        renderTo: 'gridpanel'
    });

    // create form upload
    // overwrite some defaults for nicer styling
    Bancha.scaffold.Form.fileuploadfieldDefaults = {
        buttonText: '',
        buttonConfig: {
            iconCls: 'icon-upload'
        }
    };
    
    Bancha.scaffold.Form.createPanel('User', false, {
        afterBuild: function(formConfig) {
            // change the order, so that the avatar field is the last element
            formConfig.items.push(formConfig.items.splice(5,1)[0]);
            
            // add another item after the avatar field
            formConfig.items.push({ //TODO add support for this to display the image
                xtype: 'component', 
                data: { avatar: 'none' },// TODO fixsss
                tpl: '<tpl if="avatar!=\'none\'"><span class="uploaded-image">most recently uploaded image: {avatar}<image src="{avatar}" style="width:100px;" title="most recently uploaded image"></span></tpl>'
            });
            
            // add another button
            formConfig.buttons.unshift({
                text: 'Load Record 1',
                iconCls: 'icon-load', // TODO css
                handler: Bancha.scaffold.Form.scopeButtonHandler(function() {
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
                },formConfig.id)
            });
            
            return formConfig;
        } //eo afterBuild
    }, {
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
