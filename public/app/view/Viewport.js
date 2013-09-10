Ext.define('MyApp.view.Viewport', {
    extend: 'Ext.container.Viewport',
    requires: [
        'Ext.tab.Panel',
        'Ext.layout.container.Border',
        'Ext.grid.Panel',
        'Ext.form.Panel',
        'Ext.form.field.Number'
    ],

    alias: 'widget.layout',

    layout: {
        type: 'border'
    },

    items: [
        {
            region: 'west',
            xtype: 'panel',
            title: 'List of players',
            layout: 'fit',
            items: [
                {
                    xtype: 'grid',
                    border: false,
                    columns: [
                        {
                            dataIndex: 'name',
                            flex: 1
                        },
                        {
                            dataIndex: 'surname',
                            flex: 1
                        }
                    ],
                    dockedItems: [
                        {
                            xtype: 'pagingtoolbar',
                            dock: 'bottom',
                            store: 'Players',
                            displayInfo: true
                        }
                    ],
                    store: 'Players'
                }
            ],
            width: 350
        },
        {
            region: 'center',
            xtype: 'tabpanel',
            layout: 'fit',
            items: [
                {
                    title: 'Details',
                    layout: 'fit',
                    items: [
                        {
                            xtype: 'form',
                            model: 'Player',
                            paramOrder: ['id'],
                            padding: 5,
                            border: false,
                            api: {
                                load: 'Game.Player.load',
                                submit: 'Game.Player.submit'
                            },
                            items: [
                                {
                                    xtype: 'hiddenfield',
                                    name: 'id'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'name'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'surname'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'nickname'
                                },
                                {
                                    xtype: 'numberfield',
                                    name: 'age'
                                }
                            ],
                            buttons: [
                                {
                                    text: 'Submit Form',
                                    handler: function (btn) {
                                        var form = btn.up('form').getForm(),
                                            idField = form.findField('id'),
                                            value = idField ? idField.getValue() : null;
                                        form.submit({
                                            params: {
                                                id: value
                                            }
                                        });
                                    }
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ]
});