<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajax en Vue V2</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="{{asset('css/toastr.css')}}"></script>
</head>
<body>
    <div id="main" class="container">
        <div class="row">
            <div class="col-sm-4">
                <h1>Lista vue js - AJAX</h1>
                <ul class="list-group">
                    <li v-for= "item in lists" class="list-group-item">
                            @{{ item.name }}
                    </li>
                </ul>
            </div>
            <div class="col-sm-8">
                <h1>Lista vue js - AJAX</h1>
                <pre>
                    @{{ $data }}
                </pre>
            </div>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script type="text/javascript">
        var urlUser = 'https://jsonplaceholder.typicode.com/users';
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
                axios.get(urlUser).then(response=>{
                    this.lists = response.data
                });
            }
        }
    });
</script>
</body>
</html>