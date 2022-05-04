
@forelse($<*<controller>*> as $<*<model>*>)
            <tr>
                <*<fields>*>                
                <td >
                    <div class="btn-group btn-group-crud-table " role="group" aria-label="">
                        <a href="#" class="btn-primary btn-crud-table" >
                            <span class= "fa fa-eye bt-crud-table-icon"></span> 
                            <span class="bt-crud-table-text"></span>
                        </a>
                        <a href="#" class="btn-primary btn-crud-table" >
                            <span class= "fa fa-edit bt-crud-table-icon"></span> 
                            <span class="bt-crud-table-text"></span>
                        </a>
                        <a href="#" class="btn-primary btn-crud-table" >
                            <span class= "fa fa-trash bt-crud-table-icon"></span> 
                            <span class="bt-crud-table-text"></span>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style='text-align: center; padding: 100px'>Brak rekordow</td>          
            </tr>
@endforelse 
            