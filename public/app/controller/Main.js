Ext.define('MyApp.controller.Main', {
    requires : [
        'MyApp.store.Players'
    ],
    extend: 'Ext.app.Controller',
    stores : [
        'Players'
    ],
    init : function () {
        var me = this;
        me.control({
            'layout panel > grid' : {
                'itemclick' : function (grid, record, el, index){
                    var form = Ext.ComponentQuery.query('form')[0];
                    form.loadRecord(record);
                }
            }
        });
    }
});