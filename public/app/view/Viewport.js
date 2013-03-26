Ext.define('MyApp.view.Viewport', {
    extend: 'Ext.container.Viewport',
    requires:[
        'Ext.tab.Panel',
        'Ext.layout.container.Border',
        'Ext.grid.Panel',
        'Ext.form.Panel',
        'Ext.form.field.Number'
    ],

    alias : 'widget.layout',

    layout: {
        type: 'border'
    },

    items: [{
        region: 'west',
        xtype: 'panel',
        title: 'List of players',
        layout : 'fit',
        items : [
            {
                xtype : 'grid',
                border : false,
                columns : [
                    {
                        dataIndex : 'name'
                    },
                    {
                        dataIndex : 'surname'
                    }
                ],
                store : 'Players'
            }
        ],
        width: 150
    },{
        region: 'center',
        xtype: 'tabpanel',
        layout : 'fit',
        items:[{
            title: 'Details',
            layout : 'fit',
            items : [
                {
                    xtype : 'form',
                    model : 'Player',
                    padding : 5,
                    border : false,
                    items : [
                        {
                            xtype : 'textfield',
                            name : 'name'
                        },
                        {
                            xtype : 'textfield',
                            name : 'surname'
                        },
                        {
                            xtype : 'textfield',
                            name : 'nickname'
                        },
                        {
                            xtype : 'numberfield',
                            name : 'age'
                        }
                    ]
                }
            ]
        }]
    }]
});