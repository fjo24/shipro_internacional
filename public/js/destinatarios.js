var urlDestinatarios = 'destinatarios-json/';
new Vue({
    el: '#main',
    created: function() {
      this.getUsers();  
    },
    data:{
        lists:[]
    },
    methods:{
        getUsers: function(){
            axios.get(urlDestinatarios).then(response=>{
                this.lists = response.data
            });
        }
    }
});