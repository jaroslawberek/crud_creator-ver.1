<div class="form-group">                    
    
    <input type="checkbox" name="<*<name>*>" class="<*<class>*>" id="<*<model>*>_<*<name>*>" aria-describedby="<*<name>*>" placeholder="<*<label>*>" @if(old('<*<name>*>',$<*<model>*>-><*<name>*> ?? "")==1) checked value=1 @else value=0 @endif>
      <span><*<label>*></span>
    <small id="<*<model>*>_<*<name>*>_help" class="form-text text-muted"></small>
</div>