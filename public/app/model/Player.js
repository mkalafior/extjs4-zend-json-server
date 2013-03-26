Ext.define('MyApp.model.Player', {
    extend: 'Ext.data.Model',
    fields: [
        { name: 'id', type: 'integer' },
        { name: 'name', type: 'string' },
        { name: 'surname', type: 'string' },
        { name: 'age', type: 'integer' },
        { name: 'nickname', type: 'string' }
    ],
    proxy : {
        type : 'direct',
        api : {
            read : Game.Player.read,
            destroy : Game.Player.destroy,
            create : Game.Player.create,
            update : Game.Player.update
        },
        reader : {
            type : 'json',
            root: 'Player'
        }
    }
});

