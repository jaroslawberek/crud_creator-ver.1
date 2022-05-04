
<form>
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
    {{$<*<controller>*>->links()}} 
</form>
<!--</div>-->