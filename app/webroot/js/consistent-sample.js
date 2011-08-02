/*jslint browser: true, vars: false, plusplus: true, white: true, sloppy: true */
/*global Ext, Bancha */


// when Bancha is ready, the model meta data is loaded
// from the server and the model is created....
Bancha.onModelReady('User', function(userModel) {
    var console = Ext.get('console'),
        out;
    
    out = function(text) {
        console.createChild({
            tag: 'div',
            html: text
        });
    };
    
    Ext.create('Ext.Button',{
        text: 'Fancy calculation',
        renderTo: 'buttons',
        handler: function() {
            out('Started fancy calculation');
            Bancha.getStubsNamespace().User.fancyCalculation({
                params: {
                    __bcid: Bancha.getConsistentUid()
                },
                success: function(result) {
                    out(result);
                }
            });
        }
    });
    
    Ext.create('Ext.Button',{
        text: 'Fast calculation',
        renderTo: 'buttons',
        handler: function() {
            out('Started fast calculation');
            Bancha.getStubsNamespace().User.fastCalculation({
                params: {
                    __bcid: Bancha.getConsistentUid()
                },
                success: function(result) {
                    out(result);
                }
            });
        }
    });
});

// eof
