Ext.ns('Bancha'); Bancha.REMOTE_API = {
    url: 'read-users.json',
    namespace: 'Bancha.RemoteStubs',
    "type":"remoting",
    "actions":{
        "User":[{
            "name":"load",
            "formHandler": true,
            "len":1
        },{
            "name":"submit",
            "formHandler": true,
            "len":1
        },{
            "name":"create",
            "len":1
        },{
            "name":"read",
            "len":1
        },{
            "name":"update",
            "len":1
        },{
            "name":"destroy",
            "len":1
        }]
    },
    metadata: {
        User: {
                idProperty: 'id',
                fields: [
                    {name:'id', type:'int'},
                    {name:'name', type:'string'},
                    {name:'login', type:'string'},
                    {name:'created', type:'date'},
                    {name:'email', type:'string'},
                    {name:'avatar', type:'string'},
                    {name:'weight', type:'float'},
                    {name:'height', type:'float'}
                ],
                validations: [
                    {type:'length', name:'name', min:4, max:64},
                    {type:'length', name:'login', min:3, max:64},
                    {type:'length', name:'email', min:5, max:64},
                    {type:'length', name:'avatar', max:64}
                ],
                //associations: [
                    //{type:'hasMany', model:'Post', name:'posts'},
                //],
                sorters: [{
                    property: 'name',
                    direction: 'ASC'
                }]
      }
   }
};