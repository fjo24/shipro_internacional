new Vue({
    el: '#retiro',
    created: function() {
        this.getRetiros();  
    },
    data:{
        retiros:[],
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0
        },
        offset: 2,
        /*
        newKeep: '',
        fillKeep: {'id': '', 'keep': ''},
        errors:[],
        offset: 6, */
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
            console.log(pagesArray);
            return pagesArray;
        }
    },
    methods:{
        //index sin paginacion
        /* getRetiros: function(){
            var urlRetiros = 'retiros';
            axios.get(urlRetiros).then(response=>{
                this.retiros = response.data.retiros.data
                console.log(response.data);
                this.pagination = response.data.pagination
            });
        }, */
        getRetiros: function(page){
            var urlRetiros = 'retiros?page='+page;
            axios.get(urlRetiros).then(response=>{
                this.retiros = response.data.retiros.data
                this.pagination = response.data.pagination
            });
        },
        changePage: function(page){
            this.pagination.current_page = page;
            this.getRetiros(page);
        }
    }
});