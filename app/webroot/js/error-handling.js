/*jslint browser: true, vars: false, plusplus: true, white: true, sloppy: true */
/*global Ext, Bancha */

Ext.Error.handle = function(err) {
    Ext.Msg.alert('Error', err.msg);
};

Ext.direct.Manager.on('exception', function(err){
	Ext.Msg.alert('Server-Error:'+err.message,"Where:<br />"+err.where+"<br /><br />trace:<br />"+err.trace);
});

// eof
