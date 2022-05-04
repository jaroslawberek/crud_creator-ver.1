 <!Created CRUD: --March 25, 2021, 5:19 pm-->
   <div class="btn-group crud-table-group-buttons float-right">
       <a href="{{route('players.create')}}">
           
        <button class="btn-primary float-right">
            <span class= "fa fa-trash bt-crud-table-icon"></span>
            <span class="bt-crud-table-text">Nowy</span>
        </button>
       </a>
    </div>
<form id='players-form'>
    <input type="hidden" name="ajax_search" value="1">
     
    <table class="table table-hover table-crud">
        <thead>
            <!--Pola filtracji w NAgłowku tabeli-->
			<tr class="search-tr" >
<!--nowy-->
    <th>
        <input class="form-control" type="text" name="login" value="{{$search_items['login']??''}}" role="search-item">
    </th><!--nowy-->
    <th>
        <input class="form-control" type="text" name="wzrost" value="{{$search_items['wzrost']??''}}" role="search-item">
    </th><!--nowy-->
    <th>
        <input class="form-control" type="text" name="canLogin" value="{{$search_items['canLogin']??''}}" role="search-item">
    </th><!--nowy-->
    <th>
        <input class="form-control" type="text" name="description" value="{{$search_items['description']??''}}" role="search-item">
    </th><!--nowy-->
    <th>
        <input class="form-control" type="text" name="born" value="{{$search_items['born']??''}}" role="search-item">
    </th><!--nowy-->
<th>
    
   <select name="sex" id="players_sex" class="form-control " form="players-form">
      <option value=""></option>
    <!--nowy-->
    <option value="m" @if( (isset($search_items['sex']))&&($search_items['sex']=='m') ) selected  @endif>m</option> 
<!--nowy-->
    <option value="k" @if( (isset($search_items['sex']))&&($search_items['sex']=='k') ) selected  @endif>k</option> 

</select>
</th>
<!--nowy-->
<th>
    
   <select name="position" id="players_position" class="form-control " form="players-form">
      <option value=""></option>
    <!--nowy-->
    <option value="b" @if( (isset($search_items['position']))&&($search_items['position']=='b') ) selected  @endif>b</option> 
<!--nowy-->
    <option value="o" @if( (isset($search_items['position']))&&($search_items['position']=='o') ) selected  @endif>o</option> 
<!--nowy-->
    <option value="p" @if( (isset($search_items['position']))&&($search_items['position']=='p') ) selected  @endif>p</option> 
<!--nowy-->
    <option value="n" @if( (isset($search_items['position']))&&($search_items['position']=='n') ) selected  @endif>n</option> 

</select>
</th>

</tr>          
            <!--Pola Sortowania w nagłowkach kolumn-->
            <tr class="order-tr" >
<!--nowy-->
<td class="order-item"  order-f="login" >
     <span >Login</span>
    @isset($sortField['order_field'])
        @if (($sortField['order_field']=='login') && ($sortField['sort'] === 'desc'))
            <span class="fa fa-sort-amount-down-alt "></span>                  
        @elseif (($sortField['order_field']=='login') && ($sortField['sort'] === 'asc'))
            <span class="fa fa-sort-amount-up-alt "></span>
        @else
            <span class=""></span>
        @endif                           
    @endisset
    @empty($sortField['order_field'])
        <span class=""></span>
    @endempty                    
</td>                
 <!--nowy-->
<td class="order-item"  order-f="wzrost" >
     <span >Wzrost</span>
    @isset($sortField['order_field'])
        @if (($sortField['order_field']=='wzrost') && ($sortField['sort'] === 'desc'))
            <span class="fa fa-sort-amount-down-alt "></span>                  
        @elseif (($sortField['order_field']=='wzrost') && ($sortField['sort'] === 'asc'))
            <span class="fa fa-sort-amount-up-alt "></span>
        @else
            <span class=""></span>
        @endif                           
    @endisset
    @empty($sortField['order_field'])
        <span class=""></span>
    @endempty                    
</td>                
 <!--nowy-->
<td class="order-item"  order-f="canLogin" >
     <span >CanLogin</span>
    @isset($sortField['order_field'])
        @if (($sortField['order_field']=='canLogin') && ($sortField['sort'] === 'desc'))
            <span class="fa fa-sort-amount-down-alt "></span>                  
        @elseif (($sortField['order_field']=='canLogin') && ($sortField['sort'] === 'asc'))
            <span class="fa fa-sort-amount-up-alt "></span>
        @else
            <span class=""></span>
        @endif                           
    @endisset
    @empty($sortField['order_field'])
        <span class=""></span>
    @endempty                    
</td>                
 <!--nowy-->
<td class="order-item"  order-f="description" >
     <span >Description</span>
    @isset($sortField['order_field'])
        @if (($sortField['order_field']=='description') && ($sortField['sort'] === 'desc'))
            <span class="fa fa-sort-amount-down-alt "></span>                  
        @elseif (($sortField['order_field']=='description') && ($sortField['sort'] === 'asc'))
            <span class="fa fa-sort-amount-up-alt "></span>
        @else
            <span class=""></span>
        @endif                           
    @endisset
    @empty($sortField['order_field'])
        <span class=""></span>
    @endempty                    
</td>                
 <!--nowy-->
<td class="order-item"  order-f="born" >
     <span >Born</span>
    @isset($sortField['order_field'])
        @if (($sortField['order_field']=='born') && ($sortField['sort'] === 'desc'))
            <span class="fa fa-sort-amount-down-alt "></span>                  
        @elseif (($sortField['order_field']=='born') && ($sortField['sort'] === 'asc'))
            <span class="fa fa-sort-amount-up-alt "></span>
        @else
            <span class=""></span>
        @endif                           
    @endisset
    @empty($sortField['order_field'])
        <span class=""></span>
    @endempty                    
</td>                
 <!--nowy-->
<td class="order-item"  order-f="sex" >
     <span >Płeć</span>
    @isset($sortField['order_field'])
        @if (($sortField['order_field']=='sex') && ($sortField['sort'] === 'desc'))
            <span class="fa fa-sort-amount-down-alt "></span>                  
        @elseif (($sortField['order_field']=='sex') && ($sortField['sort'] === 'asc'))
            <span class="fa fa-sort-amount-up-alt "></span>
        @else
            <span class=""></span>
        @endif                           
    @endisset
    @empty($sortField['order_field'])
        <span class=""></span>
    @endempty                    
</td>                
 <!--nowy-->
<td class="order-item"  order-f="position" >
     <span >Pozycja</span>
    @isset($sortField['order_field'])
        @if (($sortField['order_field']=='position') && ($sortField['sort'] === 'desc'))
            <span class="fa fa-sort-amount-down-alt "></span>                  
        @elseif (($sortField['order_field']=='position') && ($sortField['sort'] === 'asc'))
            <span class="fa fa-sort-amount-up-alt "></span>
        @else
            <span class=""></span>
        @endif                           
    @endisset
    @empty($sortField['order_field'])
        <span class=""></span>
    @endempty                    
</td>                
 <!--nowy-->
<td class="order-item"  order-f="logowanias" >
     <span >Logowanias</span>
    @isset($sortField['order_field'])
        @if (($sortField['order_field']=='logowanias') && ($sortField['sort'] === 'desc'))
            <span class="fa fa-sort-amount-down-alt "></span>                  
        @elseif (($sortField['order_field']=='logowanias') && ($sortField['sort'] === 'asc'))
            <span class="fa fa-sort-amount-up-alt "></span>
        @else
            <span class=""></span>
        @endif                           
    @endisset
    @empty($sortField['order_field'])
        <span class=""></span>
    @endempty                    
</td>                
 
</tr> 
        </thead>
        <tbody>       
        <!--nowy-->
@forelse($players as $player)
            <tr>
                <td>{{$player->login}}</td>
<td>{{$player->wzrost}}</td>
<td>{{$player->canLogin}}</td>
<td>{{$player->description}}</td>
<td>{{$player->born}}</td>
<td>{{$player->sex}}</td>
<td>{{$player->position}}</td>
                
                <td >
                    <div class="btn-group btn-group-crud-table " role="group" aria-label="">
                        <a href="#" class="btn-primary btn-crud-table" >
                            <span class= "fa fa-eye bt-crud-table-icon"></span> 
                            <span class="bt-crud-table-text"></span>
                        </a>
                        <a href="{{route('players.edit',['id'=>$player->id ?? ''])}}" class="btn-primary btn-crud-table" >
                            <span class= "fa fa-edit bt-crud-table-icon"></span> 
                            <span class="bt-crud-table-text"></span>
                        </a>
                        <a href="{{route('destroy-player',['id'=>$player->id ?? ''])}}" class="btn-primary btn-crud-table" >
                            <span class= "fa fa-trash bt-crud-table-icon"></span> 
                            <span class="bt-crud-table-text"></span>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style='text-align: center; padding: 100px'>Brak rekordow</td>          
            </tr>
@endforelse 
                 
        </tbody>
        <tfoot>
        </tfoot>
    </table> 
    <div class="row d-flex justify-content-center align-content-center submit-content-crud">
    {{$players->links()}} 
        
    </div>
</form>
<!--</div>-->