 <!Created CRUD: --<*<date_create>*>-->
   <div class="btn-group crud-table-group-buttons float-right">
       <a href="{{route('<*<controller>*>.create')}}">
           
        <button class="btn-primary float-right">
            <span class= "fa fa-trash bt-crud-table-icon"></span>
            <span class="bt-crud-table-text">Nowy</span>
        </button>
       </a>
    </div>
<form id='<*<controller>*>-form'>
    <input type="hidden" name="ajax_search" value="1">
     
    <table class="table table-hover table-crud">
        <thead>
            <!--Pola filtracji w NAgłowku tabeli-->
			<*<search-tr>*>          
            <!--Pola Sortowania w nagłowkach kolumn-->
            <*<order-tr>*> 
        </thead>
        <tbody>       
        <*<body>*>     
        </tbody>
        <tfoot>
        </tfoot>
    </table> 
    <div class="row d-flex justify-content-center align-content-center submit-content-crud">
    {{$<*<controller>*>->links()}} 
        
    </div>
</form>
<!--</div>-->