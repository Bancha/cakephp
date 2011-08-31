/*jslint browser: true, vars: false, plusplus: true, white: true, sloppy: true */
/*global Ext, Bancha */

Ext.Error.handle = function(err) {
    Ext.Msg.alert('Error', err.msg);
};

// eof
