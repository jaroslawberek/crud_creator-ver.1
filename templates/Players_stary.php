<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\ Player;



class Players extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

        return view('frontend.form_players');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $parametrs = $request->all();
        
//        $request->validate([
//            'login' => 'required|min:4|max:30',
//            'wzrost' => 'required|numeric',
//            'canLogin' => 'nullable|required|numeric',
//            'born' => 'required|date'], 
//            
//            ['login.required' => 'Nie podano  :attribute',
//                'login.min' => ':attribute powinien :input is not between :min - :max.',
//                'login.max' => 'Podana nazwa użykownika jest za długa',
//                'wzrost.required' => 'Nie podano wzrostu',
//                'wzrost.numeric' => 'Nieprawidłowa wartość pola :attribute',
//                'born.required' => 'Nieprawidłowa wartość pola :attribute',
//                'born.date' => 'Data urodzenia nie jest prawidłową data',
//           ]);
//        $validator = Validator::make($request->all(), [
//                    'login' => 'required|min:4|max:30',
//                    'wzrost' => 'required|numeric',
//                    'canLogin' => 'nullable|required|numeric',
//                    'born' => 'required|date'
//                        ], 
//                    ['login.required' => 'Nie podano  :attribute',
//                'login.min' => ':attribute powinien :input is not between :min - :max.',
//                'login.max' => 'Podana nazwa użykownika jest za długa',
//                'wzrost.required' => 'Nie podano wzrostu',
//                'wzrost.numeric' => 'Nieprawidłowa wartość pola :attribute',
//                'born.required' => 'Nieprawidłowa wartość pola :attribute',
//                'born.date' => 'Data urodzenia nie jest prawidłową data',
 //       ]);
//
//        if ($validator->fails()) {
//            return redirect('players/create')
//                        ->withErrors($validator)
//                        ->withInput();
//        }
        $validated = $request->validated();
        Player::create($parametrs);
        return redirect('players/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        DB::table('players')->where('id', $id)->delete();
        return redirect('players');
    }

    private function clearArray($source = [], $target = []) {

        foreach ($target as $value) {
            unset($source[$value]);
        }

        return $source;
    }

}
