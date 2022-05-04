  public function getOne(Request $request){
        if($request->ajax()){
             return response()->json([DB::table("{$request->get('model')}")->select("*")->where("id","{$request->get('id')}")->get()[0]]);
        }
    }