var menuApp = new Vue({
    el:'#menu',
    data:{
        idiomas:[
            {
                es : {
                    shop: 'MENU',
                    archive: 'ARCHIVE',
                    imprimt : 'IMPRINT'
                }
            }
        ],
        elemento: {
            shop: 'SHOP',
            archive: 'ARCHIVE',
            imprimt : 'IMPRINT'
        },
        totalEnCarrito:0
    },
    methods: {
        irAlUrl(url)
        {
            location.href = url;
        }
    },
    async mounted() {
        
    },
    

});