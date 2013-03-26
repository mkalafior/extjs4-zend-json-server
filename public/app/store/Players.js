Ext.define('MyApp.store.Players', {
    extend : 'Ext.data.Store',
    requires : [
        'MyApp.model.Player'
    ],
    model : 'MyApp.model.Player',
    storeId : "Players",
    autoLoad : true,
    autoSync: true,
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