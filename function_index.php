$sortField = ['order_field' => "login", "sort" => "asc"]; //po jakim polu pierwsze sortowanie - domyslnie pierwsze pole tabeli
        $players = Player::query();
        if ($request->get("ajax_search") == "1") { //ajaxowe wywołanie
            
            $inputs = $this->clearArray($request->all(), ['ajax_search', 'order_field', 'sort', 'page']);         
            //$inputs['canLogin'] = isset($inputs['canLogin']) ? "1" :  "0";    
            
            foreach ($inputs as $field => $value) {
                $players->where("{$field}", 'like', "%{$value}%");
            }
            
            if ($request->has('order_field')) {                
                $players->orderBy($request->get("order_field"), $request->get("sort"));
                $sortField['order_field'] = $request->get("order_field");
                $sortField['sort'] = $request->get("sort");                
            }

            $players = $players->paginate(2);
            echo view('frontend\ajax_table_players', ['players' => $players, 'search_items' => $request->all(), 'sortField' => $sortField]);
            
        } else {

            $players = $players->paginate(2);
            $table_search_container = view('frontend\ajax_table_players', ['players' => $players, //rekordy
                                            'search_items' => ['canLogin' => '1'], // pola po ktorych jest filtrowanie - do wypenienia pol
                                            'sortField' => $sortField]             // pola po ktorych sortujemy (np w tabeli rysowanie fortowaniaw nagłowku pola
                                           )->render();

            return view('frontend\table_players', ['table_search_container' => $table_search_container]);
        }