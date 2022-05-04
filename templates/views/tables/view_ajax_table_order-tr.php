<!--nowy-->
<td class="order-item"  order-f="<*<name>*>" >
    <span ><*<name>*></span>
    @isset($sortField['order_field'])
        @if (($sortField['order_field']=='<*<name>*>') && ($sortField['sort'] === 'desc'))
            <span class="fa fa-sort-amount-down-alt "></span>                  
        @elseif (($sortField['order_field']=='<*<name>*>') && ($sortField['sort'] === 'asc'))
            <span class="fa fa-sort-amount-up-alt "></span>
        @else
            <span class=""></span>
        @endif                           
    @endisset
    @empty($sortField['order_field'])
        <span class=""></span>
    @endempty                    
</td>                
 