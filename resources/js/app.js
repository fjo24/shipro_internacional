new Vue({
    el: '#crud',
    created: function() {
        this.getKeeps();  
    },
    data:{
        keeps:[],
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0
        },
        newKeep: '',
        fillKeep: {'id': '', 'keep': ''},
        errors:[],
        offset: 6,
    },
    computed:{
        isActived: function(){
            return this.pagination.current_page;
        },
        pagesNumber: function(){
            if(!this.pagination.to){
                return [];
            }

            var from = this.pagination.current_page - this.offset; //TODO offset
            if(from < 1){
                from = 1;
            }

            var to = from + (this.offset * 2); //TODO
            if(to >= this.pagination.last_page){
                to = this.pagination.last_page;
            }

            var pagesArray = [];
            while(from <= to){
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    methods:{
        //index sin paginacion
        /* getKeeps: function(){
            var urlKeeps = 'tasks';
            axios.get(urlKeeps).then(response=>{
                this.keeps = response.data.tasks.data
                this.pagination = response.data.pagination
            });
        }, */
        //index con paginacion
        getKeeps: function(page){
            var urlKeeps = 'tasks?page='+page;
            axios.get(urlKeeps).then(response=>{
                this.keeps = response.data.tasks.data
                this.pagination = response.data.pagination
            });
        },
        //eliminar
        deleteKeep: function(keep){//eliminamos
            /* alert(keep.id); */
            var url = 'tasks/' + keep.id;
            axios.delete(url).then(response=>{//si todo bien continua
                this.getKeeps(); //listamos
                toastr.error('eliminado correctamente');//mensaje  
            });
        },
        //nueva tarea
        createKeep: function(keep){
            var url = 'tasks';
            axios.post(url, {
                keep: this.newKeep//nueva tarea
            }).then(response=>{//si todo bien:
                this.getKeeps(); //listamos
                this.newKeep=''; //volvemos variable a vacia
                this.errors = [];
                $('#create').modal('hide');//para ocultar el modal
                toastr.success('Tarea creada con exito');//mensaje  
            }).catch(error=>{
                this.errors = error.response.data
            });
        },
        //precargar datos para editar
        editKeep: function(keep){//eliminamos
            this.fillKeep.id = keep.id;
            this.fillKeep.keep = keep.keep;
            $('#edit').modal('show');
        },
        updateKeep: function(id){
            var url = 'tasks/'+ id;
            axios.put(url, this.fillKeep).then(response=>{
                this.getKeeps(); //listamos
                this.fillKeep = {'id': '', 'keep': ''};
                this.errors = [];
                $('#edit').modal('hide');
                toastr.success('Tarea actualizada con exito');//mensaje  
            }).catch(error=>{
                this.errors = error.response.data
            });
        },
        changePage: function(page){
            this.pagination.current_page = page;
            this.getKeeps(page);
        }
    }
});