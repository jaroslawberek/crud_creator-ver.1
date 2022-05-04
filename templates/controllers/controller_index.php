$sortField = ['order_field' =>$request->session()->get('<*<controller>*>_table_session.order_field',"updated_at"), 'sort'=>  $request->session()->get('<*<controller>*>_table_session.sort',"desc")]; //po jakim polu pierwsze sortowanie - domyslnie pierwsze pole tabeli
        $<*<controller>*> = <*<model>*>::query();
        <*<selects>*>
        <*<joins>*>
        if ($request->get("ajax_search") == "1") { //ajaxowe wywołanie
            
            $inputs = $this->clearArray($request->all(), ['ajax_search', 'order_field', 'sort', 'page']);         
            //$inputs['canLogin'] = isset($inputs['canLogin']) ? "1" :  "0";    
            
            foreach ($inputs as $field => $value) {
                if ($value != "")
                    $<*<controller>*>->where("{$field}", 'like', "%{$value}%");
            }
            
            if ($request->has('order_field')) {                
                $<*<controller>*>->orderBy($request->get("order_field"), $request->get("sort"));
                $sortField['order_field'] = $request->get("order_field");
                $sortField['sort'] = $request->get("sort");                
            }

            $<*<controller>*> = $<*<controller>*>
                    <*<hasMany_Count>*><*<hasMany>*>
                    <*<belongsTo>*>
                    ->paginate(5);
             $request->session()->put('<*<controller>*>_table_session',$request->all());
            echo view('frontend\ajax_table_<*<controller>*>', ['<*<controller>*>' => $<*<controller>*>, 'search_items' => $request->all(), 'sortField' => $sortField]);
            
        } else {
             $inputs = $this->clearArray($request->session()->get('<*<controller>*>_table_session'), ['ajax_search', 'order_field', 'sort', 'page']);                
             if($inputs)           
             foreach ($inputs as $field => $value) {
                if ($value != "") 
                    $<*<controller>*>->where("{$field}", 'like', "%{$value}%");
            }

            $<*<controller>*> = $<*<controller>*>->orderBy($sortField['order_field'],$sortField['sort'])
                     <*<hasMany_Count>*><*<hasMany>*>
                     <*<belongsTo>*>
                     ->paginate(5);
                     
            $table_search_container = view('frontend\ajax_table_<*<controller>*>', ['<*<controller>*>' => $<*<controller>*>, //rekordy
                                            'search_items' => $request->session()->get('<*<controller>*>_table_session'), // pola po ktorych jest filtrowanie - do wypenienia pol
                                            'sortField' => $sortField]             // pola po ktorych sortujemy (np w tabeli rysowanie fortowaniaw nagłowku pola
                                           )->render();

            return view('frontend\table_<*<controller>*>', ['table_search_container' => $table_search_container]);
        }