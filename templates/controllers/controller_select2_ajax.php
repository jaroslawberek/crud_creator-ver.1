public function select2_ajax(Request $request){
      if ($request->ajax()) {
            $res = [DB::table("{$request->get('model')}")->select("id", "{$request->get('field')} as text", "{$request->get('model')}.*")
                        ->where("{$request->get('field')}", 'like', "%{$request->get('search')}%")->get()];
            return response()->json($res);
        }
    }