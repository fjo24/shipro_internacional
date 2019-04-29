@extends('layouts.admin')

@section('title', 'Shipro Internacional')

@section('content')
{{-- <link rel="stylesheet" href="{{asset('web/assets/css/home.css')}}"> --}}
<div class="right_col" role="main">
    <div class="row">
        formulario aqui
    </div>
  </div>
@endsection
@section('js')
    <script type="text/javascript">
$(document).ready(function(){

    $(".filter-button").click(function(){
        var value = $(this).attr('data-filter');
        
        if(value == "all")
        {
            //$('.filter').removeClass('hidden');
            $('.filter').show('1000');
        }
        else
        {
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
            $(".filter").not('.'+value).hide('3000');
            $('.filter').filter('.'+value).show('3000');
            
        }
    });
    
    if ($(".filter-button").removeClass("active")) {
$(this).removeClass("active");
}
$(this).addClass("active");

});
    </script>
@endsection        
