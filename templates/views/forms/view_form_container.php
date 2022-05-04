 <!Created CRUD: --<*<date_create>*>-->
@extends('layouts.frontend')
@section('content')
<script>
     $("document").ready(function(){
         var c3 = crudForm($("#crud-<*<controller>*>-form-container"));
             c3.setSettings({
                 "ajaxFileds": "",
//                 'onValided': function (field_id, msg) {
//                     //alert(field_id + " " + msg.messages);
//                     if (msg.messages != "OK") {
//                         $("#" + field_id).addClass("field-error");
//                         $("#" + field_id+"_error").text(msg.messages)
//                     } else {
//                         $("#" + field_id).removeClass("field-error");
//                         $("#" + field_id+"_error").text("")
//                     }
//                 },
//                 'onValidedStart': function (field_id) {
//
//                 },
//                 'onValidedEnd': function (field_id) {
//
//                 },

             });
             c3.start();
         })
         
         <*<addSelect2_Fk_body>*>
 </script>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>

</div>
@endif
<div id="crud-<*<controller>*>-form-container" class="form-crud-container container" target-controller="<*<controller>*>"> @if($update?? ""==true)
    <form id="<*<controller>*>-form" class=" form-crud" method="POST" action="{{ route('<*<controller>*>.update',['id'=>$<*<model>*>->id]?? "") }}" enctype="multipart/form-data">
         @csrf
         @method('PUT')
    @else
   <form  id="<*<controller>*>-form" class=" form-crud" method="POST" action="{{ route('<*<controller>*>.store') }}" enctype="multipart/form-data">
    @endif
    
        @csrf
        <div class="row d-flex justify-content-center align-content-center form-crud-row">
            <div class="col-md-6   form-crud-col">
                $<*<form_inputs>*> 
            </div>  
        </div>
        <div class="row d-flex justify-content-center align-content-center submit-content-crud">
            <input type="submit" class="btn-primary form-submit-crud" value="Zapisz">
        </div>
    </form>
</div>
@endsection