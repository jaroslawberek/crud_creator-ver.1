<div class="form-group">                    
     <label for="<*<model>*>_<*<name>*>"><*<label>*></label>
    <select  name="<*<name>*>" class="<*<class>*>" id="<*<model>*>_<*<name>*>" aria-describedby="<*<name>*>" placeholder="<*<label>*>" model="<*<model_fk>*>">
        @if( old('<*<name>*>') )
            <option value="{{old('<*<name>*>')}}"></option>
        @else
        @isset($player->id)
            <option value="{{$<*<model>*>-><*<name>*>}}"></option>
        @endisset
        @endif
    </select>    
     <small id="<*<model>*>_<*<name>*>_error" class="form-text text-muted"></small>
</div>
